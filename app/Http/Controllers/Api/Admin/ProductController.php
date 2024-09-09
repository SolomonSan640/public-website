<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\GeneralImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $columns = $this->getColumns(strtolower($country));
        if (strtolower($country) === "mm") {
            $products = Product::with('categoryMm', 'subCategoryMm', 'countryMm', 'currencyMm')->select($columns)->orderBy('updated_at', 'desc')->get();
        } else {
            $products = Product::with('categoryEn', 'subCategoryEn', 'countryEn', 'currencyEn')->select($columns)->orderBy('updated_at', 'desc')->get();
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $products], 200);
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

            // $folderName = 'products';
            // $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image

            // if (!$imageFileName) {
            //     return response()->json(['error' => 'Image upload failed'], 400);
            // }

            // GeneralImage::create([
            //     'product_id' => $data->id,
            //     'name' => "Product Image",
            //     'file_path' => $imageFileName,
            // ]);

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Product'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Product'])], 400);
        }
    }

    public function edit($id)
    {
        $products = Product::with('category', 'subCategory', 'country', 'currency')->findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $products], 200);
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
            $products = Product::findOrFail($id);

            $userId = auth()->user()->id;
            $productId = $products->id;
            $oldPrice = $products->price;

            $products->fill($data->toArray());
            $products->update();

            $folderName = 'products';
            $imageFileName = $this->singleImage($request, 'image', $folderName);

            // if (!$imageFileName) {
            //     return response()->json(['error' => 'Image upload failed'], 400);
            // }

            $generalImage = GeneralImage::where('product_id', $productId)->get();
            if ($generalImage->isNotEmpty()) {
                foreach ($generalImage as $image) {
                    $image->update([
                        'file_path' => $imageFileName,
                    ]);
                }
            } else {
                GeneralImage::create([
                    'product_id' => $productId,
                    'file_path' => $imageFileName,
                ]);
            }

            ProductLog::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'old_price' => $oldPrice,
                'new_price' => $data['price'],
            ]);

            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Product'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Product'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFail', ['attribute' => 'Product'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $products = Product::findOrFail($id);
            $products->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Product'])], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeleted', ['attribute' => 'Product'])], 400);
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
        $data['sub_category_id'] = $request->sub_category_id;
        $data['country_id'] = $request->country_id;
        $data['currency_id'] = $request->currency_id;
        $data['sku'] = $request->sku;
        $data['quantity'] = $request->quantity;
        $data['unit'] = $request->unit;

        $data['price'] = $request->price;


        return new Product($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => [
                'required',
                Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_mm' => [
                'required_without:name_en',
                Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_th' => [
                'required_without:name_en',
                Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
            ],
            'name_kr' => [
                'required_without:name_en',
                Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
            ],
            'sku' => [
                'required',
                Rule::unique('products')->ignore($id)->whereNUll('deleted_at'),
            ],
            'category_id' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required',
            'unit' => 'required',

        ], [
            // 'price.required' => 'Price is required',
            // 'price.integer' => 'Price must be number',
            // 'quantity.required' => 'Quantity is required',
            // 'quantity.integer' => 'Quantity must be integer',
            // 'unit.required' => 'Unit is required',
            // 'sku.required' => 'SKU is required',
            // 'sku.unique' => 'SKU is already taken',
            'name_en.unique' => __('validation.dataNameUniqueEnglish', ['attribute' => 'Category']),
            'name_mm.unique' => __('validation.dataNameUniqueMyanmar', ['attribute' => 'Category']),
            'name_th.unique' => __('validation.dataNameUniqueThai', ['attribute' => 'Category']),
            'name_kr.unique' => __('validation.dataNameUniqueKorea', ['attribute' => 'Category']),
            'name_en.required' =>  __('validation.dataNameRequireEnglish', ['attribute' => 'Category']),
            'name_mm.required_without' =>  __('validation.dataNameRequireMyanmar', ['attribute' => 'Category', 'values' => 'Category (English)']),
            'name_th.required_without' =>  __('validation.dataNameRequireThai', ['attribute' => 'Category', 'values' => 'Category (English)']),
            'name_kr.required_without' =>  __('validation.dataNameRequireKorea', ['attribute' => 'Category', 'values' => 'Category (English)']),
            'category_id.required' => __('validation.dataSelect', ['attribute' => 'Category']),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    public function productLog()
    {
        $productLog = ProductLog::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $productLog], 200);
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
            return ['id', 'category_id', 'sub_category_id', 'country_id', 'currency_id', 'name_mm', 'sku', 'quantity', 'price', 'description_mm', 'remark_mm'];
        } else {
            return ['id', 'category_id', 'sub_category_id', 'country_id', 'currency_id', 'name_en', 'sku', 'quantity', 'price', 'description_en', 'remark_en'];
        }
    }
}
