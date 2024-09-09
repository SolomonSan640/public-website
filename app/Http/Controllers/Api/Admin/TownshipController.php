<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Township;
use App\Models\TownshipGeo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class TownshipController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $townships = Township::with('city', 'geo')->select($columns)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $townships], 200);
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
                    TownshipGeo::create([
                        'township_id' => $data->id,
                        'start_latitude' => $geo['start_latitude'],
                        'end_latitude' => $geo['end_latitude'],
                        'start_longitude' => $geo['start_longitude'],
                        'end_longitude' => $geo['end_longitude'],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Township'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Township'])], 400);
        }
    }

    public function edit($id)
    {
        $townships = Township::with('city')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $townships], 200);
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
            $townships = Township::findOrFail($id);
            $townships->fill($data->toArray());
            $townships->update();

            $geos = $request->geolocations;
            if ($geos) {
                $incomingIds = [];
                foreach ($geos as $geo) {
                    $provinceGeo = TownshipGeo::find($geo['id']);
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
                        TownshipGeo::create([
                            'township_id' => $townships->id,
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => 1,
                        ]);
                    }
                }
                TownshipGeo::whereNotIn('id', $incomingIds)->delete();
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Township'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Township'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFail', ['attribute' => 'Township'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $townships = Township::findOrFail($id);
            $townships->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Township'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Township'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFail', ['attribute' => 'Township'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['short_name'] = $request->short_name;
        $data['city_id'] = $request->city_id;

        return new Township($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('townships')->ignore($id)->whereNull('deleted_at'),
            ],
            'short_name' => [
                'required',
                Rule::unique('townships')->ignore($id)->whereNull('deleted_at'),
            ],
            'city_id' => [
                'required',
            ],
        ], [
            'name.unique' => __('validation.dataNameUnique', ['attribute' => 'Township']),
            'name.required' => __('validation.dataNameRequire', ['attribute' => 'Township']),
            'short_name.unique' => __('validation.dataNameUnique', ['attribute' => 'Short Name']),
            'short_name.required' => __('validation.dataNameRequire', ['attribute' => 'Short Name']),
            'city_id.required' => __('validation.dataSelect', ['attribute' => 'City']),
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
        return ['id', 'city_id', 'short_name', 'name'];
    }
}
