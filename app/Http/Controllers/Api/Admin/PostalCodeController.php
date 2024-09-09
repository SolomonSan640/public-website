<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\PostalCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostalCodeController extends Controller
{
    public function index()
    {
        $postalCodes = PostalCode::with('city', 'township')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $postalCodes], 200);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $this->validateCreateData($request);
        try {
            $data = $this->getCreateData($request);
            $data->fill($data->toArray());
            $data->save();
            DB::commit();
            return response()->json(['status' => 201, 'message' => 'Postal Code created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Postal Code created fail'], 400);
        }
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $validationResult = $this->validateCreateData($request);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $postalCodes = PostalCode::findOrFail($id);
            $postalCodes->fill($data->toArray());
            $postalCodes->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Postal Code updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Postal Code updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $postalCodes = PostalCode::findOrFail($id);
            $postalCodes->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Postal Code deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Postal Code deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        // Define the fields and their language keys
        $data['name'] = $request->name;
        $data['township_id'] = $request->township_id;
        $data['city_id'] = $request->city_id;

        return new PostalCode($data);
    }

    protected function validateCreateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Postal code is required.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
