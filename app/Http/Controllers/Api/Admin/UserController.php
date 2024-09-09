<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return response()->json(['status' => 200, 'data' => $users], 200);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $validationResult = $this->validateCreateData($request, null);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $data->fill($data->toArray());
            $data->save();
            DB::commit();
            return response()->json(['status' => 201, 'message' => 'User created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'User created fail'], 400);
        }
    }

    public function edit($id)
    {
        DB::beginTransaction();
        $user = User::select('name', 'password', 'email', 'phone', 'gender', 'address')
                        ->findOrFail($id);

        return response()->json(['status' => 200, 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        // $validationResult = $this->validateCreateData($request, $id);
        // if ($validationResult !== null) {
        //     return $validationResult;
        // }
        try {

            $data = $this->getCreateData($request);
            $users = User::findOrFail($id);
            $users->fill($data->toArray());
            $users->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'User updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'User updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $users = User::findOrFail($id);
            $users->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'User deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'User deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['gender'] = $request->gender;


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
            'phone.required' => 'phone is required',
            'email.unique' => 'Email is already taken',
            'phone.unique' => 'Phone Number is already taken',
            'phone' => 'The phone format is invalid',
            'address' => 'The address is required',
            'passsword.required' => 'Password is required',
            'password.min' => 'Password must be at least 8',
            'confirm_password' => 'Confirm password must be the same as password',
            'gender.required' => 'Gender is required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

}
