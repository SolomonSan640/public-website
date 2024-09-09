<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Models\UserShop;
use Throwable;
use App\Models\Shop;
use App\Models\User;
use App\Models\ZipCode;
use App\Models\PostalCode;
use App\Models\GeneralImage;
use Illuminate\Http\Request;
use App\Models\SmsVerfication;
use Illuminate\Validation\Rule;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MerchantRegisterController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $userId = auth()->user()->id;
        $users = User::with('country', 'city')->where('id', $userId)->orderBy('updated_at', 'desc')->get();
        $image = GeneralImage::where('user_id', $userId)->first();
        $selectShop = UserShop::where('user_id', $userId)->value('shop_id');
        $getShop = Shop::where('id', $selectShop)->select('name_en', 'name_mm')->get();
        return response()->json(['status' => 200, 'data' => $users, 'image' => $image, 'shop' => $getShop], 200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateCreateData($request, null);
        if ($validationResult !== null) {
            return $validationResult;
        }

        try {
            $data = $this->getCreateData($request);
            // $genToken = str_shuffle(md5(date("ymdhis")));
            // $data['token'] = $genToken;
            $data['status'] = 1;

            $data->fill($data->toArray());

            // change phone to international format
            // $phone = new PhoneNumber($request->phone, 'MM');
            // $data['phone'] = $phone->formatE164();
            $data->save();
            $tokens = $data->createToken('User')->plainTextToken;

            $userId = $data->id;
            $existingShop = UserShop::where('user_id', $userId)->first();

            if ($existingShop) {
                return response()->json(['status' => 400, 'error' => 'The user already has a shop with this name.'], 400);
            }

            $shops = Shop::create([
                'name_en' => $request->shop_name,
            ]);

            UserShop::create([
                'shop_id'=> $shops->id,
                'user_id'=> $userId,
            ]);

            $selectShop = UserShop::where('user_id', $userId)->value('shop_id');
            $getShop = Shop::where('id', $selectShop)->select('name_en', 'name_mm')->get();

            // $shop = Shop::create(['name' => $request->shop_name]);
            // $userShopData = ['user_id' => $data->id, 'shop_id' => $shop->id];
            // UserShop::create($userShopData);

            // $verificationCode = mt_rand(100000, 999999);
            // SmsVerification::create([
            //     'user_id' => $data->id,
            //     'phone' => $request->phone,
            //     'code' => $verificationCode,
            // ]);
            // $this->sendVerificationSms($phone, $verificationCode);

            DB::commit();
            return response()->json(['status' => 201, 'token' => $tokens, 'message' => __('success.dataCreated', ['attribute' => 'User']), 'data' => $data, 'shop' => $getShop], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('success.dataCreatedFail', ['attribute' => 'Township'])], 400);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateUpdateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $users = User::findOrFail($id);
            $users->fill($data->toArray());
            $users->update();


            $userId = auth()->user()->id;
            $shopId = UserShop::where('user_id', $userId)->value('shop_id');

            $updated = Shop::where('id', $shopId)->update([
                'name_en' => $request->shop_name,
                'name_mm' => $request->shop_name_mm ?? '',
            ]);

            if ($updated) {
                $getShop = Shop::where('id', $shopId)->select('name_en', 'name_mm')->get();
            } else {
                $newShop = Shop::create([
                    'id' => $shopId,
                    'name_en' => $request->shop_name,
                    'name_mm' => $request->shop_name_mm ?? '',
                ]);

                UserShop::create([
                    'shop_id'=> $newShop->id,
                    'user_id'=> $userId,
                ]);


                $getShop = collect([$newShop]);
            }

            $folderName = 'users';
            $imageFileName = $this->base64($request, 'image', $folderName);// use trait to upload image
            $images = GeneralImage::where('user_id', $id)->select('id', 'user_id', 'file_path')->get();


            if ($images->isNotEmpty()) {
                foreach ($images as $image) {
                    $image->update([
                        'user_id' => $users->id,
                        'file_path' => $imageFileName,
                    ]);
                }
            } else {
                GeneralImage::create([
                    'user_id' => $users->id,
                    'file_path' => $imageFileName,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'User']), 'data' => $users, 'image' => $image, 'shop' => $getShop], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('success.dataUpdatedFail', ['attribute' => 'User'])], 400);
        }
    }

    protected function getCreateData(Request $request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['address'] = $request->address;

        $role_id = 2;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        // $data['gender'] = $request->gender;
        $data['role_id'] = $role_id;
        $data['phone'] = $request->phone;
        $data['country_id'] = $request->country_id;
        $data['city_id'] = $request->city_id;
        $data['postal_code'] = $request->postal_code;
        $data['zip_code'] = $request->zip_code;

        return new User($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'phone' => [
                'required',
                // 'phone:MM',
                'regex:/^09\d{9}$/',
                Rule::unique('users')->ignore($id),
            ],
            // 'gender' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'postal_code'=> 'required',
            'zip_code'=> 'required',
            'shop_name'=> 'required',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
            'confirm_password' => 'same:password',

        ], [
            'name.required' => 'User name is required',
            'email.required' => 'email is required',
            'email.unique' => 'Email is already taken',
            'phone.unique' => 'Phone Number is already taken',
            'phone' => 'The phone format is invalid',
            'address' => 'The address is required',
            'passsword.required' => 'Password is required',
            'password.min' => 'Password must be at least 8',
            'confirm_password' => 'Confirm password must be the same as password'
            // 'gender' => 'Please choose your gender',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    protected function validateUpdateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            // 'email' => [
            //     'required',
            //     Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            // ],
            'phone' => [
                'required',
                // 'phone:MM',
                'regex:/^09\d{9}$/',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            ],
            // 'gender' => 'required',
            'address' => 'required',
            // 'country_id' => 'required',
            // 'city_id' => 'required',
            'zip_code'=> 'required',
            'postal_code'=> 'required',
            // 'shop_name'=> 'required'
        ], [
            'name.required' => 'User name is required',
            'email.required' => 'email is required',
            'email.unique' => 'Email is already taken',
            'phone.unique' => 'Phone Number is already taken',
            'phone' => 'The phone format is invalid',
            'address' => 'The address is required',
            // 'gender' => 'Please choose your gender',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    // public function sendVerificationSms($phoneNumber, $verificationCode)
    // {
    //     $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
    //     $authToken = config('app.twilio')['TWILIO_AUTH_TOKEN'];

    //     try {
    //         $client = new Client($accountSid, $authToken);
    //         $message = $client->messages->create(
    //             $phoneNumber,
    //             [
    //                 'from' => config('app.twilio')['TWILIO_PHONE_NUMBER'],
    //                 'body' => 'CODE: ' . $verificationCode,
    //             ]
    //         );
    //         return $message->sid;
    //     } catch (\Exception $e) {
    //         logger()->error('Twilio SMS sending failed: ' . $e->getMessage());
    //         return false;
    //     }
    // }

    public function verifySms(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:6',
        ]);

        // Find the SMS verification record
        $smsVerification = SmsVerfication::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if ($smsVerification) {
            // Mark the user as verified
            $user = User::find($smsVerification->user_id);
            $user->update(['phone_verified_at' => now()]);
            $smsVerification->update(['is_verified' => true]);

            // Create token here
            $token = $user->createToken('User')->plainTextToken;

            return response()->json(['status' => 200, 'message' => 'Verified', 'token' => $token], 200);
        } else {
            return response()->json(['status' => 400, 'message' => 'Not Verified'], 200);
        }
    }

    private function setLocale($country)
    {
        $supportedLocales = ['en', 'mm'];
        if (in_array($country, $supportedLocales)) {
            app()->setLocale($country);
        } else {
            app()->setLocale('en');
        }
    }
}
