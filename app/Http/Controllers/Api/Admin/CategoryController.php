<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GeneralImage;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        $categories = Category::select($columns)->orderBy('updated_at', 'desc')->get();

        $image = [];
        foreach ($categories as $category) {
            $image[] = GeneralImage::where('category_id', $category->id)->select('id', 'category_id', 'file_path')->get();
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $categories, 'image' => $image], 200);
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

            $folderName = 'categories';
            $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image

            if ($imageFileName) {
                GeneralImage::create([
                    'category_id' => $data->id,
                    'name' => "Category Image",
                    'file_path' => $imageFileName,
                ]);
            }
            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Category'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Category'])], 400);
        }
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $categories], 200);
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
            $categories = Category::findOrFail($id);
            $categories->fill($data->toArray());
            $categoryId = $categories->id;
            $categories->update();

            $folderName = 'categories';
            $imageFileName = $this->singleImage($request, 'image', $folderName);

            $generalImage = GeneralImage::where('category_id', $categoryId)->get();

            if ($generalImage) {
                foreach ($generalImage as $image) {
                    $image->update([
                        'category_id' => $categoryId,
                        'name' => "Updated Category Image",
                        'file_path' => $imageFileName,
                    ]);
                }
            } else if ($imageFileName) {
                GeneralImage::create([
                    'category_id' => $categoryId,
                    'file_path' => $imageFileName,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Category'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Category'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Category'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $categories = Category::findOrFail($id);
            $categories->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Category'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Category'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Category'])], 400);
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

        return new Category($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_mm' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_th' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_kr' => [
                'required_without:name_en',
                'nullable',
                Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
            ],
        ], [
            'name_en.unique' => __('validation.dataNameUniqueEnglish', ['attribute' => 'Category']),
            'name_mm.unique' => __('validation.dataNameUniqueMyanmar', ['attribute' => 'Category']),
            'name_th.unique' => __('validation.dataNameUniqueThai', ['attribute' => 'Category']),
            'name_kr.unique' => __('validation.dataNameUniqueKorea', ['attribute' => 'Category']),
            'name_en.required' => __('validation.dataNameRequireEnglish', ['attribute' => 'Category']),
            'name_mm.required_without' => __('validation.dataNameRequireMyanmar', ['attribute' => 'Category', 'values' => 'Category (English)']),
            'name_th.required_without' => __('validation.dataNameRequireThai', ['attribute' => 'Category', 'values' => 'Category (English)']),
            'name_kr.required_without' => __('validation.dataNameRequireKorea', ['attribute' => 'Category', 'values' => 'Category (English)']),
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
            return ['id', 'name_mm', 'description_mm', 'remark_mm'];
        } else {
            return ['id', 'name_en', 'description_en', 'remark_en'];
        }
    }
}
