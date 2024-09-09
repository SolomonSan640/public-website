<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\AboutPageMM;
use App\Models\ContentLog;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AboutPageController extends Controller
{
    use ImageUploadTrait;
    public function index($country)
    {
        $this->setLocale(strtolower($country));
        $about = AboutPage::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $about], 200);
    }

    public function aboutPage(Request $request)
    {
        $this->setLocale(strtolower($request->country));
        if (strtolower($request->country) === 'mm') {
            $about = AboutPageMM::orderBy('created_at')->get();
            if ($about->isEmpty()) {
                return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => null], 200);
            }
            return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $about[0]], 200);
        } else {
            $about = AboutPage::orderBy('created_at')->get();
            if ($about->isEmpty()) {
                return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => null], 200);
            }
            return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $about[0]], 200);
        }
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

            // create log
            $user = Auth::user()->id;
            ContentLog::create([
                'about_id' => $data->id,
                'created_by' => $user,
            ]);

            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'About Page'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'About Page'])], 400);
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
            $about = AboutPage::findOrFail($id);
            $about->fill($data->toArray());
            $about->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'About Page'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'About Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'About Page'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $about = AboutPage::findOrFail($id);
            $about->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'About Page'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'About Page'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'About Page'])], 400);
        }
    }

    protected function getCreateData($request, $id)
    {
        $data = [];

        $fieldBases = ['title', 'content'];
        $imageBases = ['image'];
        $mobileImages = ['image_m'];

        $existingData = AboutPage::find($id);

        if ($existingData) {
            $data = $existingData->toArray();
        }

        foreach ($imageBases as $image) {
            for ($i = 1; $i <= 15; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'AboutPage';
                $imagePath = $this->singleImage($request, $image . '_' . $i, $folderName);
                if ($imagePath !== null) {
                    $data[$image . '_' . $i] = $imagePath;
                }
            }
        }

        foreach ($mobileImages as $image) {
            for ($i = 1; $i <= 10; $i++) {
                $fields[$image . '_' . $i] = $i === 1 ? $image . '_' . $i : $image . '_1';
                $folderName = 'AboutPage';
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

        return new AboutPage($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_1' => 'required',
        ], [
            'title_1.required' => __('validation.dataNameRequire', ['attribute' => 'About Page Title']),
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
