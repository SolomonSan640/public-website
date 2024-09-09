<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\ProvinceGeo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ProvinceController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $provinces = Province::select($columns)->with('firstLabel', 'geo')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $provinces], 200);
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
                    ProvinceGeo::create([
                        'province_id' => $data->id,
                        'start_latitude' => $geo['start_latitude'],
                        'end_latitude' => $geo['end_latitude'],
                        'start_longitude' => $geo['start_longitude'],
                        'end_longitude' => $geo['end_longitude'],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Province'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Province'])], 400);
        }
    }

    public function edit($id)
    {
        $provinces = Province::with('country')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $provinces], 200);
    }

    public function geoUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        // $validationResult = $this->validateCreateData($request, $id);
        // if ($validationResult !== null) {
        //     return $validationResult;
        // }
        try {
            $provinces = ProvinceGeo::findOrFail($id);
            $provinces->update([
                'province_id' => $provinces->id,
                'start_latitude' => $request->start_latitude,
                'end_latitude' => $request->end_latitude,
                'start_longitude' => $request->start_longitude,
                'end_longitude' => $request->end_longitude,
                'is_show' => $request->is_show,
            ]);
            DB::commit();

            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Province Geo'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Province Geo'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Province Geo'])], 400);
        }
    }

    public function geoDestroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $provinces = ProvinceGeo::findOrFail($id);
            $provinces->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Province Geo'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Province Geo'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Province Geo'])], 400);
        }
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
            $provinces = Province::findOrFail($id);
            $provinces->fill($data->toArray());
            $provinces->update();
            DB::commit();

            $geos = $request->geolocations;
            if ($geos) {
                $incomingIds = [];
                foreach ($geos as $geo) {
                    $provinceGeo = ProvinceGeo::find($geo['id']);
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
                        ProvinceGeo::create([
                            'province_id' => $provinces->id,
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => 1,
                        ]);
                    }
                }
                ProvinceGeo::whereNotIn('id', $incomingIds)->delete();
            }
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Province'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Province'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Province'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $provinces = Province::findOrFail($id);
            $provinces->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Province'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Province'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Province'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['country_id'] = $request->country_id;
        $data['first_label_id'] = $request->first_label_id;

        return new Province($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('provinces')->whereNull('deleted_at')->ignore($id),
            ],
        ], [
            'name.unique' => __('validation.dataNameUnique', ['attribute' => 'Province']),
            'name.required' => __('validation.dataNameRequire', ['attribute' => 'Province']),
            'country_id' => __('validation.dataSelect', ['attribute' => 'Country']),
            'first_label_id' => __('validation.dataSelect', ['attribute' => 'Label']),
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
        return ['id', 'name', 'country_id', 'first_label_id'];
    }

    public function provinceSearch($provinceId)
    {
        // $regions = City::where('province_id', $provinceId)->select('id', 'province_id', 'name')->with('province')->groupBy('id', 'province_id', 'name')->get();

        // if ($regions->isEmpty()) {
        //     return response()->json(['message' => 'No City found.', 'data' => []], 200);
        // }

        // return response()->json(['message' => 'City found.', 'data' => $regions], 200);

        $cities = City::where('province_id', $provinceId)->select('id', 'province_id', 'timezone_id', 'second_label_id', 'name')
            ->with('province', 'timezone', 'secondLabel', 'geo')
            ->groupBy('id', 'province_id', 'second_label_id', 'timezone_id', 'name')
            ->get();
        $countries = Province::where('id', $provinceId)->first();

        $data = ['province_id' => $countries->id, 'province' => $countries->name, 'cities' => []];

        if ($cities->isEmpty()) {
            return response()->json(['message' => 'No cities Found', 'data' => $data], 200);
        }

        $regions = [];

        foreach ($cities as $city) {
            $regions[] = [
                'id' => $city->id,
                'name' => $city->name,
                'secondlabel' => $city->secondLabel,
                'timezone' => $city->timezone,
                'geo' => $city->geo,
            ];
        }

        $response = [
            'message' => 'Regions found.',
            'data' => [
                'province_id' => $data['province_id'],
                'province' => $data['province'],
                'cities' => $regions,
            ],
        ];

        return response()->json($response, 200);
    }
}
