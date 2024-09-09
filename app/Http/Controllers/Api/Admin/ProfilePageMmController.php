<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use Illuminate\Http\Request;
use App\Models\ProfilePageMM;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfilePageMmController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $profile = ProfilePageMM::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $profile], 200);
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
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'Profile Page'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'Profile Page'])], 400);
        }
    }

    public function edit($id)
    {
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
            $data = $this->getCreateData($request, $id);
            $profile = ProfilePageMM::findOrFail($id);
            $profile->fill($data->toArray());
            $profile->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Profile Page'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Profile Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Profile Page'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $profile = ProfilePageMM::findOrFail($id);
            $profile->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'Profile Page'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'Profile Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'Profile Page'])], 400);
        }
    }

    protected function getCreateData($request, $id)
    {
        $data = [];

        $fieldBases = ['title', 'content'];
        $imageBases = ['image'];
        $mobileImages = ['image_m'];

        $existingData = ProfilePageMM::find($id);

        if ($existingData) {
            $data = $existingData->toArray();
        }

        foreach ($imageBases as $image) {
            for ($i = 1; $i <= 20; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'ProfilePage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                }
            }
        }

        foreach ($mobileImages as $image) {
            for ($i = 1; $i <= 10; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'ProfilePage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                }
            }
        }

        foreach ($fieldBases as $base) {
            for ($i = 1; $i <= 15; $i++) {
                $fieldKey = $base . '_' . $i;

                // Only update if request has a non-empty value
                if (!empty($request->{$fieldKey})) {
                    $data[$fieldKey] = $request->{$fieldKey};
                }
            }
        }

        return new ProfilePageMM($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_1' => 'required',
        ], [
            'title_1.required' => __('validation.dataNameRequire', ['attribute' => 'Profile Page Title']),
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
