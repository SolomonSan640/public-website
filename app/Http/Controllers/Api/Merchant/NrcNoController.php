<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Models\NrcNo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Throwable;

class NrcNoController extends Controller
{
    public function index()
    {
        $nrcno = NrcNo::with('nrc_type.nrc_township.township', 'nrc_type.nrc_township.nrc_code')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $nrcno], 200);
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
            return response()->json(['status' => 201, 'message' => 'Nrc No created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Nrc No created fail'], 400);
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
            $nrcno = NrcNo::findOrFail($id);
            $nrcno->fill($data->toArray());
            $nrcno->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Nrc No updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Nrc No updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $nrcno = NrcNo::findOrFail($id);
            $nrcno->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Nrc No deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Nrc No deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name_en'] = $request->name_en;
        $data['name_mm'] = $request->name_mm;

        $data['nrc_type_id'] = $request->nrc_type_id;

        return new NrcNo($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                'digits:6',
                Rule::unique('nrc_nos')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_mm' => [
                'required_without:name_en',
                Rule::unique('nrc_nos')->ignore($id)->whereNull('deleted_at'),
            ],
        ], [
            'name_en.unique' => 'Nrc No in (English) already exists.',
            'name_mm.unique' => 'Nrc No in (Myanmar) already exists',
            'name_en.required' => 'Nrc No in English is require.',
            'name_mm.required' => 'Nrc No in (Myanmar) is required.',
            'name_en.digits' => 'Nrc No in (English) digit must be at least 6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
