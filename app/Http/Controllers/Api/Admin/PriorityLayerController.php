<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountInfo;
use App\Models\GeoLocation;
use App\Models\PriorityLayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class PriorityLayerController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $pLayers = PriorityLayer::select($columns)->with('layer', 'priority', 'pLayer', 'cinfo')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $pLayers], 200);
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

            $cinfos = $request->iso2;
            if ($cinfos) {
                CountInfo::create([
                    'priority_layer_id' => $data->id,
                    'iso2' => $request->iso2,
                    'iso3' => $request->iso3,
                    'currency' => $request->currency,
                    'callcode' => $request->callcode,
                    'flag' => $request->flag,
                    'description' => $request->description,
                    'remark' => $request->remark,
                    'is_show' => 1,
                ]);
            }

            $geos = $request->geolocations;
            if ($geos) {
                foreach ($geos as $geo) {
                    GeoLocation::create([
                        'priority_layer_id' => $data->id,
                        'start_latitude' => $geo['start_latitude'],
                        'end_latitude' => $geo['end_latitude'],
                        'start_longitude' => $geo['start_longitude'],
                        'end_longitude' => $geo['end_longitude'],
                        'is_show' => 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Priority Layer'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Priority Layer'])], 400);
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
            $pLayers = PriorityLayer::findOrFail($id);
            $pLayers->fill($data->toArray());
            $pLayers->update();

            $cinfos = $request->iso2;
            if ($cinfos) {
                $infoupdate = CountInfo::where('priority_layer_id', $pLayers->id)->first();
                $infoupdate->update([
                    'priority_layer_id' => $pLayers->id,
                    'iso2' => $request->iso2,
                    'iso3' => $request->iso3,
                    'currency' => $request->currency,
                    'callcode' => $request->callcode,
                    'flag' => $request->flag,
                    'description' => $request->description,
                    'remark' => $request->remark,
                    'is_show' => 1,
                ]);
            }

            $geos = $request->geolocations;
            if ($geos) {
                $incomingIds = [];
                foreach ($geos as $geo) {
                    $geoLocation = GeoLocation::find($geo['id']);
                    $incomingIds[] = $geo['id'];
                    if ($geoLocation) {
                        $geoLocation->update([
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => $geo['is_show'],
                        ]);
                    } else {
                        GeoLocation::create([
                            'priority_layer_id' => $pLayers->id,
                            'start_latitude' => $geo['start_latitude'],
                            'end_latitude' => $geo['end_latitude'],
                            'start_longitude' => $geo['start_longitude'],
                            'end_longitude' => $geo['end_longitude'],
                            'is_show' => 1,
                        ]);
                    }
                }
                GeoLocation::whereNotIn('id', $incomingIds)->delete();
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Priority Layer'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Priority Layer'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Priority Layer'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pLayers = PriorityLayer::findOrFail($id);

            $cinfos = CountInfo::where('priority_layer_id', $pLayers->id)->first();
            if ($cinfos) {
                $cinfos->delete();
            }
            $geolocations = GeoLocation::where('priority_layer_id', $pLayers->id)->get();
            if ($geolocations) {
                foreach ($geolocations as $geo) {
                    $geo->delete();
                }
            }

            $pLayers->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Priority Layer'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Priority Layer'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Priority Layer'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['layer_id'] = $request->layer_id;
        $data['priority_id'] = $request->priority_id;
        $data['name'] = $request->name;
        $data['layer_priority_id'] = $request->layer_priority_id;
        $data['is_show'] = $request->is_show;

        return new PriorityLayer($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('priority_layers')->ignore($id)->whereNull('deleted_at'),
            ],
            'layer_id' => 'required',
            'priority_id' => 'required',
        ], [
            'name.unique' => 'Priority Layer name already taken.',
            'name.required' => 'Priority Layer name is required.',
            'layer_id.required' => 'Priority Layer name is required.',
            'priority_id.required' => 'Priority Layer name is required.',
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
        return ['id', 'layer_id', 'priority_id', 'name', 'layer_priority_id', 'is_show'];
    }
}
