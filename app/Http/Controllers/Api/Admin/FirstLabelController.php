<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\FirstLabel;
use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class FirstLabelController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $firsts = FirstLabel::select($columns)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $firsts], 200);
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
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'FirstLabel'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'FirstLabel'])], 400);
        }
    }

    public function edit($id)
    {
        $firsts = FirstLabel::with('country')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $firsts], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        // $decryptId = decrypt($id);
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $firsts = FirstLabel::findOrFail($id);
            $firsts->fill($data->toArray());
            $firsts->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'FirstLabel'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'FirstLabel'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'FirstLabel'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $firsts = FirstLabel::findOrFail($id);
            $firsts->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'FirstLabel'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'FirstLabel'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'FirstLabel'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name'] = $request->name;

        return new FirstLabel($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('first_labels')->whereNull('deleted_at')->ignore($id),
            ],
        ], [
            'name.unique' => __('validation.dataNameUnique', ['attribute' => 'FirstLabel']),
            'name.required' => __('validation.dataNameRequire', ['attribute' => 'FirstLabel']),
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
        return ['id', 'name'];
    }

    public function labelSearch($labelId)
    {
        $regions = Province::where('first_label_id', $labelId)->select('id', 'first_label_id', 'name')->with('firstLabel')->groupBy('id', 'first_label_id', 'name')->get();

        if ($regions->isEmpty()) {
            return response()->json(['error' => 'No Provinces found for the provided Region.'], 200);
        }

        return response()->json(['message' => 'Region found.', 'data' => $regions], 200);
    }
}
