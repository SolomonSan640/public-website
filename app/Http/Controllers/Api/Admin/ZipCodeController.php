<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\ZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ZipCodeController extends Controller
{
    public function index()
    {
        $zipCodes = ZipCode::with('city.country')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $zipCodes], 200);
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
            return response()->json(['status' => 201, 'message' => 'Zip Code created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Zip Code created fail'], 400);
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
            $zipCodes = ZipCode::findOrFail($id);
            $zipCodes->fill($data->toArray());
            $zipCodes->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Zip Code updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Zip Code updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $zipCodes = ZipCode::findOrFail($id);
            $zipCodes->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Zip Code deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Zip Code deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['city_id'] = $request->city_id;

        return new ZipCode($data);
    }

    protected function validateCreateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Zip code is required.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
