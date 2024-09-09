<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\HomePageMM;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomePageMmController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {

        $this->setLocale(strtolower($country));
        $index = HomePageMM::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $index], 200);
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
            $data = $this->getCreateData($request, null);
            $data->fill($data->toArray());
            $data->save();
            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Home Page'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Home Page'])], 400);
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request, $id);
            $index = HomePageMM::findOrFail($id);
            $index->fill($data->toArray());
            $index->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Home Page'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Home Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Home Page'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $index = HomePageMM::findOrFail($id);
            $index->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Home Page'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Home Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Home Page'])], 400);
        }
    }

    protected function getCreateData($request, $id)
    {
        $data = [];

        $sliderTitles = ['slider_title'];
        $fieldBases = ['title', 'content'];
        $imageBases = ['image'];
        $mobileImages = ['image_m'];
        $sliderImages = ['slider_image'];

        $existingData = HomePageMM::find($id); // Assuming you are updating the record with ID 1

        if ($existingData) {
            $data = $existingData->toArray();
        }

        // Process image fields
        foreach ($imageBases as $image) {
            for ($i = 1; $i <= 20; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'HomePage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                } // else keep existing data
            }
        }

        foreach ($sliderImages as $image) {
            for ($i = 1; $i <= 5; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'HomePage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                } // else keep existing data
            }
        }

        foreach ($mobileImages as $image) {
            for ($i = 1; $i <= 10; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'HomePage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                } // else keep existing data
            }
        }

        foreach ($fieldBases as $base) {
            for ($i = 1; $i <= 20; $i++) {
                // Construct the field key
                $fieldKey = $base . '_' . $i;

                // Only update if request has a non-empty value
                if (!empty($request->{$fieldKey})) {
                    $data[$fieldKey] = $request->{$fieldKey};
                }
            }
        }

        foreach ($sliderTitles as $base) {
            for ($i = 1; $i <= 5; $i++) {
                // Construct the field key
                $fieldKey = $base . '_' . $i;

                // Only update if request has a non-empty value
                if (!empty($request->{$fieldKey})) {
                    $data[$fieldKey] = $request->{$fieldKey};
                }
            }
        }
        return new HomePageMM($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slider_title_1' => 'required',
        ], [
            'slider_title_1.required' => __('validation.dataNameRequire', ['attribute' => 'Home Page Title']),
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
}
