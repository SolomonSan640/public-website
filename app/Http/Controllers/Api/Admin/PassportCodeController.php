<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Validation\Rule;
use Throwable;
use App\Models\PassportCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PassportCodeController extends Controller
{
    public function index()
    {
        $passportCodes = PassportCode::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $passportCodes], 200);
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
            return response()->json(['status' => 201, 'message' => 'Passport Code created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport Code created fail'], 400);
        }
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $passportCodes = PassportCode::findOrFail($id);
            $passportCodes->fill($data->toArray());
            $passportCodes->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Passport Code updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport Code updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $passportCodes = PassportCode::findOrFail($id);
            $passportCodes->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Passport Code deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport Code deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data['name'] = $request->name;

        return new PassportCode($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('passport_codes')->whereNull('deleted_at')->ignore($id),
            ]
        ], [
            'name.required' => 'Passport Code is required.',
            'name.unique' => 'Passport Code is already taken',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
