<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MerchantLoginController extends Controller
{
    public function login(Request $request)
    {

        $validator = $this->validateLoginData($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $users = User::where('email', $credentials['email'])->first();

        $this->setLocale(strtolower($request->country));
        if ($users && $users->role->name === 'Merchant' && Hash::check($credentials['password'], $users->password)) {
            $token = $users->createToken('Token Name')->plainTextToken;
            $messages = ['status' => 200, 'token' => $token, 'merchant' => $users, 'message' => __('success.LoginSuccess')];
            return response()->json($messages);
        } else {
            return response()->json(['message' => __('error.loginFailed')], 401);
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

    public function user($country)
    {
        $this->setLocale(strtolower($country));
        $users = User::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $users], 200);
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
