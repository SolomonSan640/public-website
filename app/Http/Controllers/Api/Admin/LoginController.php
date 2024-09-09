<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    protected $authService;
    public function __construct()
    {
        $this->authService = app(AuthService::class);
    }

    // public function login(Request $request)
    // {

    //     // $validator = $this->validateLoginData($request);

    //     // if ($validator->fails()) {
    //     //     return response()->json([
    //     //         'status' => 422,
    //     //         'message' => 'Validation failed',
    //     //         'errors' => $validator->errors(),
    //     //     ], 422);
    //     // }

    //     $this->setLocale(strtolower($request->country));
    //     $credentials = $request->only('email', 'password');
    //     $users = User::where('email', $credentials['email'])->first();

    //     if ($users && Hash::check($credentials['password'], $users->password)) {

    //         $token = $users->createToken('Token Name')->plainTextToken;
    //         return response()->json(['status' => 200, 'token' => $token, 'admin' => $users, 'message' => __('success.LoginSuccess')]);
    //     } else {
    //         return response()->json(['message' => __('error.loginFailed')], 401);
    //     }
    // }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $baseUrl = env('APP_URL');

            $response = $this->authService->authenticate($request->email, $request->password, $baseUrl);
            if (isset($response['token']) && $response['user']['site']['site_url'] == env("APP_URL")) {
                if (!User::where('email', $response['user']['email'])->exists()) {
                    $user = User::create([
                        'name' => $response['user']['name'],
                        'email' => $response['user']['email'],
                        'password' => Hash::make($request->password),
                        'is_admin' => 1,
                    ]);
                }
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    return response()->json(['message' => __('error.loginFailed')], 401);
                }
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json(['message' => __('error.loginFailed')], 401);
                }

                $token = $user->createToken('Token Name')->plainTextToken;

                return response()->json(['status' => 200, 'token' => $token, 'admin' => $user, 'message' => __('success.LoginSuccess')]);
            } else {
                return response()->json(['message' => __('error.loginFailed')], 401);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $this->setLocale(strtolower($request->country));
        $request->user()->tokens()->delete();
        return response()->json(['message' => __('success.logout')]);
    }

    protected function validateLoginData(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     $this->checkPasswordValidation($request);
    //     $user = User::findOrFail($id);
    //     $user->name = $request->input('name', $user->name);

    //     $db_password = $user->password;
    //     $input_old_password = $request->input('old_password');
    //     $request->input('image');

    //     if (Hash::check($input_old_password, $db_password)) {
    //         if ($request->has('new_password')) {
    //             $user->password = Hash::make($request->input('new_password'));
    //         }
    //         if ($request->hasFile('image')) {
    //             $profileImage = $request->file('image');
    //             $path = $profileImage->storeAs('profile_images', 'user_' . $user->id . '.' . $profileImage->extension(), 'public');
    //             $user->image = $path;
    //         }
    //         $user->save();
    //     } else {
    //         // Return an error indicating that the old password is incorrect
    //         return response()->json(['error' => 'Old password is incorrect'], 401);
    //     }
    // }

    public function user()
    {
        $users = User::orderBy('updated_at', 'desc')->get();

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $users], 200);
    }

    protected function checkPasswordValidation($request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'new_password' => [
                'required',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
            'new_password_confirm' => 'required|same:new_password',
        ];
        // $messages = [
        //     'oldPassword.required' => "Old Password must be filled.",
        //     'newPassword.required' => "New Password must be Filled.",
        //     'newPassword.min' => 'The password must be at least :min characters long and must contain at least one letter, one number, one capitalized letter, and one special character.',
        //     'newPasswordConfirm.required' => "New Password Confirmation must be Filled.",
        // ];
        Validator::make($request->all(), $rules)->validate();
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
