<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\NrcTownship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NrcTownshipController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $nrctownships = NrcTownship::with('township','nrcCode')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $nrctownships], 200);
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
            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Nrc Township'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Nrc Township'])], 400);
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
            $nrctownships = NrcTownship::findOrFail($id);
            $nrctownships->fill($data->toArray());
            $nrctownships->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Nrc Township'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Nrc Township'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Nrc Township'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $nrctownships = NrcTownship::findOrFail($id);
            $nrctownships->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Nrc Township'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Nrc Township'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Nrc Township'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data['township_id'] = $request->township_id;
        $data['nrc_code_id'] = $request->nrc_code_id;

        return new NrcTownship($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'township_id' => 'required',
            'nrc_code_id' => [
                'required',
                Rule::unique('nrc_townships', 'nrc_code_id')->whereNull('deleted_at')->where('township_id', $request->input('township_id'))->ignore($id),
                'max:255',
            ],
        ], [
            'nrc_code_id.unique' => __('validation.dataNameUnique', ['attribute' => 'Nrc Code']),
            'township_id.required' =>  __('validation.dataNameRequire', ['attribute' => 'Nrc Township']),
            'nrc_code_id.required' =>  __('validation.dataNameRequire', ['attribute' => 'Nrc Code']),
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
