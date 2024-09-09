<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityGeo;
use App\Models\TimeZone;
use App\Models\Township;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class CityController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $cities = City::with('province', 'timezone', 'secondLabel', 'geo')->select($columns)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $cities], 200);
    }

    public function timezone()
    {
        $this->setLocale(strtolower('en'));
        $timezones = TimeZone::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $timezones], 200);
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

            $geos = $request->geolocations;
            if ($geos) {
                foreach ($geos as $geo) {
                    CityGeo::create([
                        'city_id' => $data->id,
                        'start_latitude' => $geo['start_latitude'],
                        'end_latitude' => $geo['end_latitude'],
                        'start_longitude' => $geo['start_longitude'],
                        'end_longitude' => $geo['end_longitude'],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'City'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'City'])], 400);
        }
    }

    public function edit($id)
    {
        $cities = City::with('country')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $cities], 200);
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
            $cities = City::findOrFail($id);
            $cities->fill($data->toArray());
            $cities->update();

            $geos = $request->geolocations;
            if ($geos) {
                $incomingIds = [];
                foreach ($geos as $geo) {
                    $provinceGeo = CityGeo::find($geo['id']);
                    $incomingIds[] = $geo['id'];
                    if ($provinceGeo) {
                        $provinceGeo->update([
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => $geo['is_show'],
                        ]);
                    } else {
                        CityGeo::create([
                            'city_id' => $cities->id,
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => 1,
                        ]);
                    }
                }
                CityGeo::whereNotIn('id', $incomingIds)->delete();
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'City'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'City'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'City'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $cities = City::findOrFail($id);
            $cities->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'City'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'City'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'City'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['province_id'] = $request->province_id;
        $data['timezone_id'] = $request->timezone_id;
        $data['second_label_id'] = $request->second_label_id;

        return new City($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('cities')->whereNull('deleted_at')->ignore($id),
            ],
            'province_id' => 'required',
            'timezone_id' => 'required',
            'second_label_id' => 'required',
        ], [
            'name.unique' => __('validation.dataNameUnique', ['attribute' => 'City']),
            'name.required' => __('validation.dataNameRequire', ['attribute' => 'City']),
            'province_id' => __('validation.dataSelect', ['attribute' => 'Province']),
            'timezone_id' => __('validation.dataSelect', ['attribute' => 'Timezone']),
            'second_label_id' => __('validation.dataSelect', ['attribute' => 'Label']),
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
        return ['id', 'province_id', 'name', 'timezone_id', 'second_label_id'];
    }

    public function citySearch($cityId)
    {
        $townships = Township::where('city_id', $cityId)->with('city')->select('id', 'city_id', 'name', 'short_name')->groupBy('id', 'city_id', 'name', 'short_name')->get();
        $cities = City::where('id', $cityId)->with('secondLabel')->first();

        $data = ['second_label_id' => $cities->secondLabel->id, 'second_label' => $cities->secondLabel->name, 'townships' => []];

        if ($townships->isEmpty()) {
            return response()->json(['message' => 'No townships Found', 'data' => $data], 200);
        }

        $regions = [];

        foreach ($townships as $township) {
            $regions[] = [
                'id' => $township->id,
                'name' => $township->name,
                'short_name' => $township->short_name,
                'city' => $township->city,
                'geo' => $township->geo,
            ];
        }

        $response = [
            'message' => 'Townships found.',
            'data' => [
                'id' => $data['second_label_id'],
                'second_label' => $data['second_label'],
                'townships' => $regions,
            ],
        ];

        return response()->json($response, 200);
    }
}
