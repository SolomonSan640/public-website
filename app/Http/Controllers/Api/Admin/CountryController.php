<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use App\Models\Township;
use App\Models\ServiceArea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryController extends Controller
{
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $countries = Country::orderBy('updated_at', 'desc')->get();
        foreach ($countries as $country) {
            $data[] = [
                'id' => $country->id,
                'name' => $country->name,
                'code' => $country->code,
            ];
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $data], 200);
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
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Country'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Country'])], 400);
        }
    }

    public function edit($id)
    {
        $countries = Country::findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $countries], 200);
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
            $countries = Country::findOrFail($id);
            $countries->fill($data->toArray());
            $countries->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Country'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Country'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Country'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $countries = Country::findOrFail($id);
            $countries->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Country'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Country'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Country'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['name_en'] = $request->name_en;
        $data['name_mm'] = $request->name_mm;
        $data['name_th'] = $request->name_th;
        $data['name_kr'] = $request->name_kr;

        $data['description_en'] = $request->description_en;
        $data['description_mm'] = $request->description_mm;
        $data['description_th'] = $request->description_th;
        $data['description_kr'] = $request->description_kr;

        $data['remark_en'] = $request->remark_en;
        $data['remark_mm'] = $request->remark_mm;
        $data['remark_th'] = $request->remark_th;
        $data['remark_kr'] = $request->remark_kr;

        $data['code'] = $request->code;
        return new Country($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($id),
            ],
            'name_mm' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($id),
            ],
            'name_th' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($id),
            ],
            'name_kr' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($id),
            ],
            'code' => [
                'required',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($id),
            ],
        ], [
            'name_en.unique' => __('validation.dataNameUniqueEnglish', ['attribute' => 'Country']),
            'name_mm.unique' => __('validation.dataNameUniqueMyanmar', ['attribute' => 'Country']),
            'name_th.unique' => __('validation.dataNameUniqueThai', ['attribute' => 'Country']),
            'name_kr.unique' => __('validation.dataNameUniqueKorea', ['attribute' => 'Country']),
            'name_en.required' => __('validation.dataNameRequireEnglish', ['attribute' => 'Country']),
            'name_mm.required_without' => __('validation.dataNameRequireMyanmar', ['attribute' => 'Country', 'values' => 'Country (English)']),
            'name_th.required_without' => __('validation.dataNameRequireThai', ['attribute' => 'Country', 'values' => 'Country (English)']),
            'name_kr.required_without' => __('validation.dataNameRequireKorea', ['attribute' => 'Country', 'values' => 'Country (English)']),
            'code.required' => __('validation.dataNameRequire', ['attribute' => 'Country']),
            'code.unique' => __('validation.dataNameUnique', ['attribute' => 'Country']),
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
            return ['id', 'name_mm as name', 'code', 'description_mm', 'remark_mm'];
        } else {
            return ['id', 'name_en as name', 'code', 'description_en', 'remark_en'];
        }
    }

    public function regionCountry($regionId)
    {
        $regions = ServiceArea::where('regional_id', $regionId)->select('country_id')->with('country')->groupBy('country_id')->get();

        if ($regions->isEmpty()) {
            return response()->json(['error' => 'No Country found for the provided Region.'], 200);
        }

        return response()->json(['message' => 'Country found.', 'data' => $regions], 200);
    }

    public function divisionCountry($countryId){
        $countries = Province::where('country_id',$countryId)->select('id','first_label_id','name')->with('firstLabel')->groupBy('id','first_label_id','name')->get();
        if($countries->isEmpty()){
            return response()->json(['error'=>'No Division Found for the provided Country.'],200);
        }
        return response()->json(['message'=>'Division Found','data'=>$countries],200);
    }

    public function divisionCity($provinceId){
        $cities = City::where('province_id',$provinceId)->select('id','second_label_id','name','timezone_id')->with(['secondLabel','timezone'])->groupBy('id','second_label_id','name','timezone_id')->get();
        if($cities->isEmpty()){
            return response()->json(['error'=>'No City Found for the provided Division.'],200);
        }
        return response()->json(['message'=>'City Found','data'=>$cities],200);
    }

    public function townshipCity($cityId){
        $townships = Township::where('city_id',$cityId)->select('id','name','short_name','city_id','is_show')->with('geo')->groupBy('id','name','short_name','city_id','is_show')->get();
        if($townships->isEmpty()){
            return response()->json(['error'=>'No townships Found for the provided City.'],200);
        }
        return response()->json(['message'=>'Township Found','data'=>$townships],200);
    }

    public function countryCity($countryId)
    {
        $cities = Province::where('country_id', $countryId)->with('firstLabel', 'geo')->select('id', 'country_id', 'first_label_id', 'name')->groupBy('id', 'country_id', 'first_label_id', 'name')->get();
        $countries = ServiceArea::where('country_id', $countryId)->with('firstLabel')->first();

        $data = ['first_label_id' => $countries->firstLabel->id, 'first_label' => $countries->firstLabel->name, 'regions' => []];

        if ($cities->isEmpty()) {
            return response()->json(['message' => 'No Cities Found', 'data' => $data], 200);
        }

        $regions = [];

        foreach ($cities as $city) {
            $regions[] = [
                'id' => $city->id,
                'name' => $city->name,
                'geo' => $city->geo
            ];
        }

        $response = [
            'message' => 'Regions found.',
            'data' => [
                'id' => $data['first_label_id'],
                'first_label' => $data['first_label'],
                'regions' => $regions,
            ],
        ];

        return response()->json($response, 200);
    }
}
