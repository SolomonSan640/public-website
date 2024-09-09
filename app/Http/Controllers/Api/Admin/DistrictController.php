<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DistrictGeo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class DistrictController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $districts = District::select($columns)->with('city', 'secondLabel')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $districts], 200);
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

            $geo = $request->start_latitude;
            if ($geo) {
                for ($i = 0; $i < count($geo); $i++) {
                    DistrictGeo::create([
                        'district_id' => $data->id,
                        'start_latitude' => $request->start_latitude[$i],
                        'end_latitude' => $request->end_latitude[$i],
                        'start_longitude' => $request->start_longitude[$i],
                        'end_longitude' => $request->end_longitude[$i],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'District'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'District'])], 400);
        }
    }

    public function edit($id)
    {
        $districts = District::with('country')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $districts], 200);
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
            $districts = DistrictGeo::findOrFail($id);
            $districts->update([
                'district_id' => $districts->id,
                'start_latitude' => $request->start_latitude,
                'end_latitude' => $request->end_latitude,
                'start_longitude' => $request->start_longitude,
                'end_longitude' => $request->end_longitude,
                'is_show' => $request->is_show,
            ]);
            DB::commit();

            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'District Geo'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'District Geo'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'District Geo'])], 400);
        }
    }

    public function geoDestroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $districts = DistrictGeo::findOrFail($id);
            $districts->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'District Geo'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'District Geo'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'District Geo'])], 400);
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
            $districts = District::findOrFail($id);
            $districts->fill($data->toArray());
            $districts->update();

            $geo = $request->start_latitude;
            if ($geo) {
                for ($i = 0; $i < count($geo); $i++) {
                    DistrictGeo::create([
                        'district_id' => $districts->id,
                        'start_latitude' => $request->start_latitude[$i],
                        'end_latitude' => $request->end_latitude[$i],
                        'start_longitude' => $request->start_longitude[$i],
                        'end_longitude' => $request->end_longitude[$i],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'District'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'District'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'District'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $districts = District::findOrFail($id);
            $districts->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'District'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'District'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'District'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['city_id'] = $request->city_id;
        $data['second_label_id'] = $request->second_label_id;

        return new District($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('districts')->whereNull('deleted_at')->ignore($id),
            ],
        ], [
            'name.unique' => __('validation.dataNameUnique', ['attribute' => 'District']),
            'name.required' => __('validation.dataNameRequire', ['attribute' => 'District']),
            'city_id' => __('validation.dataSelect', ['attribute' => 'Country']),
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
        return ['id', 'name', 'city_id', 'second_label_id'];
    }
}
