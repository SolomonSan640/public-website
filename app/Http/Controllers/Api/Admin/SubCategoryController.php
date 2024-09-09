<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralImage;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class SubCategoryController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns($country);
        if (strtolower($country) === "mm") {
            $subcategories = SubCategory::with('categoryMm')->select($columns)->orderBy('updated_at', 'desc')->get();
        } else {
            $subcategories = SubCategory::with('categoryEn')->select($columns)->orderBy('updated_at', 'desc')->get();
        }

        $image = [];
        foreach ($subcategories as $subcategory) {
            $image[] = GeneralImage::where('sub_category_id', $subcategory->id)->select('id', 'sub_category_id', 'file_path')->get();
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $subcategories, 'image' => $image], 200);
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

            $folderName = 'subcategories';
            $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image

            if ($imageFileName) {
                GeneralImage::create([
                    'sub_category_id' => $data->id,
                    'name' => "Sub Category Image",
                    'file_path' => $imageFileName,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Sub Category'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Sub Category'])], 400);
        }
    }

    public function edit($id)
    {
        $subcategories = SubCategory::findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $subcategories], 200);

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
            $subcategories = SubCategory::findOrFail($id);
            $subcategories->fill($data->toArray());
            $subcategories->update();

            $folderName = 'subcategories';
            $imageFileName = $this->singleImage($request, 'image', $folderName);

            $subCategoryId = $subcategories->id;
            $generalImage = GeneralImage::where('sub_category_id', $subCategoryId)->get();

            if ($generalImage) {
                foreach ($generalImage as $image) {
                    $image->update([
                        'sub_category_id' => $subCategoryId,
                        'name' => "Updated Sub Category Image",
                        'file_path' => $imageFileName,
                    ]);
                }
            } else if ($imageFileName) {
                GeneralImage::create([
                    'sub_category_id' => $subCategoryId,
                    'file_path' => $imageFileName,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Sub Category'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Sub Category'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFail', ['attribute' => 'Sub Category'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $subcategories = SubCategory::findOrFail($id);
            $subcategories->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Sub Category'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Sub Category'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFail', ['attribute' => 'Sub Category'])], 400);
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

        $data['category_id'] = $request->category_id;

        return new SubCategory($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                Rule::unique('sub_categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_mm' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('sub_categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_th' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('sub_categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_kr' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('sub_categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'category_id' => [
                'required',
            ],
        ], [
            'name_en.unique' => __('validation.dataNameUniqueEnglish', ['attribute' => 'Sub Category']),
            'name_mm.unique' => __('validation.dataNameUniqueMyanmar', ['attribute' => 'Sub Category']),
            'name_th.unique' => __('validation.dataNameUniqueThai', ['attribute' => 'Sub Category']),
            'name_kr.unique' => __('validation.dataNameUniqueKorea', ['attribute' => 'Sub Category']),
            'name_en.required' => __('validation.dataNameRequireEnglish', ['attribute' => 'Sub Category']),
            'name_mm.required_without' => __('validation.dataNameRequireMyanmar', ['attribute' => 'Sub Category', 'values' => 'Sub Category (English)']),
            'name_th.required_without' => __('validation.dataNameRequireThai', ['attribute' => 'Sub Category', 'values' => 'Sub Category (English)']),
            'name_kr.required_without' => __('validation.dataNameRequireKorea', ['attribute' => 'Sub Category', 'values' => 'Sub Category (English)']),
            'category_id.required' => __('validation.dataSelect', ['attribute' => 'Category']),
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
            return ['id', 'category_id', 'name_mm', 'description_mm', 'remark_mm'];
        } else {
            return ['id', 'category_id', 'name_en', 'description_en', 'remark_en'];
        }
    }
}
