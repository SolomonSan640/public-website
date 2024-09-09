<?php

namespace App\Http\Controllers\Api\Merchant;

use Throwable;
use App\Models\Shop;
use App\Models\UserShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('country', 'city')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $shops], 200);
    }

    public function create()
    {
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
            $data->fill($data->toArray());
            $data->save();

            $userId = Auth::user()->id;
            $userShopData = ['user_id' => $userId, 'shop_id' => $data->id];
            UserShop::create($userShopData);

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Shop'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Shop'])], 400);
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $shops = Shop::findOrFail($id);
            $shops->fill($data->toArray());
            $shops->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Shop'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Shop'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFail', ['attribute' => 'Shop'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $shops = Shop::findOrFail($id);
            $shops->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Shop'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Shop'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFail', ['attribute' => 'Shop'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['address_en'] = $request->address_en;
        $data['address_mm'] = $request->address_mm;
        $data['address_th'] = $request->address_th;
        $data['address_kr'] = $request->address_kr;

        $data['description_en'] = $request->description_en;
        $data['description_mm'] = $request->description_mm;
        $data['description_th'] = $request->description_th;
        $data['description_kr'] = $request->description_kr;

        $data['remark_en'] = $request->remark_en;
        $data['remark_mm'] = $request->remark_mm;
        $data['remark_th'] = $request->remark_th;
        $data['remark_kr'] = $request->remark_kr;

        $data['country_id'] = $request->country_id;
        $data['city_id'] = $request->city_id;
        $data['township_id'] = $request->township_id;
        $data['postal_code_id'] = $request->postal_code_id;
        $data['zip_code_id'] = $request->zip_code_id;
        $data['name'] = $request->name;
        $data['open_time'] = $request->open_time;
        $data['close_time'] = $request->close_time;

        return new Shop($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'address' => 'required',
        ], [
            'name.required' =>  __('validation.dataNameRequire', ['attribute' => 'Shop']),
            'open_time.required' =>  __('validation.dataNameRequire', ['attribute' => 'Shop Open Time']),
            'close_time.required' =>  __('validation.dataNameRequire', ['attribute' => 'Shop Close Time']),
            'address.required' =>  __('validation.dataNameRequire', ['attribute' => 'Shop Address']),
            'city_id.required' => __('validation.dataSelect', ['attribute' => 'City']),
            'country_id.required' => __('validation.dataSelect', ['attribute' => 'Country']),

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
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
