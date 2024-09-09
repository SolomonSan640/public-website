<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceArea;
use App\Models\City;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ServiceAreaController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $serviceareas = ServiceArea::select($columns)->with('country', 'firstLabel')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $serviceareas], 200);
    }

    public function getServiceAreaCountries($country,$regional_id)
    {
        $this->setLocale(strtolower($country));
        $serviceareas = ServiceArea::with('countryName', 'regionalName', 'firstLabel')->where('regional_id', $regional_id)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $serviceareas], 200);
    }

    public function middleEast($country)
    {
        $this->setLocale(strtolower($country));
        $serviceareas = ServiceArea::with('countryName', 'regionalName')->where('regional_id', 2)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $serviceareas], 200);
    }

    public function northAmerica($country)
    {
        $this->setLocale(strtolower($country));
        $serviceareas = ServiceArea::with('countryName', 'regionalName')->where('regional_id', 3)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $serviceareas], 200);
    }

    public function europe($country)
    {
        $this->setLocale(strtolower($country));
        $serviceareas = ServiceArea::with('countryName', 'regionalName')->where('regional_id', 4)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $serviceareas], 200);
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
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'ServiceArea'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'ServiceArea'])], 400);
        }
    }

    public function edit($id)
    {
        $country = ServiceArea::findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $country], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $serviceareas = ServiceArea::findOrFail($id);
            $serviceareas->fill($data->toArray());
            $serviceareas->update();

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'ServiceArea'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'ServiceArea'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'ServiceArea'])], 400);
        }
    }

    // public function delete($id){
    //     $servicearea = ServiceArea::findOrFail($id);
    //     $servicearea->is_show = 0;
    //     $servicearea->update();

    //     return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'ServiceArea'])], 200);
    // }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $serviceareas = ServiceArea::findOrFail($id);
            // $countryId = $serviceareas->country_id;
            // $cities = City::where('country_id', $countryId)->delete();
            $serviceareas->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'ServiceArea'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'ServiceArea'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'ServiceArea'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['country_id'] = $request->country_id;
        $data['regional_id'] = $request->regional_id;
        $data['first_label_id'] = $request->first_label_id;
        $data['is_show'] = 1;

        return new ServiceArea($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => [
                'required',
                Rule::unique('service_areas')->ignore($id)->whereNull('deleted_at'),
            ],
            'regional_id' => [
                'required',
            ],
            'first_label_id' => [
                'required',
            ],
        ], [
            'country_id.unique' => __('validation.dataNameUnique', ['attribute' => 'Country']),
            'category_id.required' => __('validation.dataSelect', ['attribute' => 'Country']),
            'regional_id.required' => __('validation.dataSelect', ['attribute' => 'Regional']),
            'first_label_id.required' => __('validation.dataSelect', ['attribute' => 'Label']),
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
        return ['id', 'country_id', 'regional_id', 'first_label_id'];
    }
}


