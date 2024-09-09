<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurrencyController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $currencies = Currency::select($columns)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $currencies], 200);
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
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Currency'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Currency'])], 400);
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
            $currencies = Currency::findOrFail($id);
            $currencies->fill($data->toArray());
            $currencies->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Currency'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Currency'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Currency'])], 400);
        }
    }

    public function destroy($id, $country)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($country));
        try {
            $currencies = Currency::findOrFail($id);
            $currencies->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Currency'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Currency'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Currency'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['name_en'] = $request->name_en;
        $data['name_mm'] = $request->name_mm;
        $data['name_th'] = $request->name_th;
        $data['name_kr'] = $request->name_kr;

        return new Currency($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                Rule::unique('currencies')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_mm' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('currencies')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_th' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('currencies')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_kr' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('currencies')->ignore($id)->whereNull('deleted_at'),
            ]
        ], [
            'name_en.unique' => 'Currency name in (English) already taken.',
            'name_mm.unique' => 'Currency name in (Myanmar) already taken',
            'name_th.unique' => 'Currency name in (Thai) already taken',
            'name_kr.unique' => 'Currency name in (Korea) already taken',
            'name_en.required' => 'Currency name in (English) is required.',
            'name_mm.required_without' => 'Currency name in (Myanmar) is required',
            'name_th.required_without' => 'Currency name in (Thai) is required',
            'name_kr.required_without' => 'Currency name in (Korea) is required.',
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

    private function getColumns($country)
    {
        if ($country == 'mm') {
            return ['id', 'name_mm'];
        } else {
            return ['id', 'name_en'];
        }
    }
}
