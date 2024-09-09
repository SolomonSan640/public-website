<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Passport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PassportController extends Controller
{
    public function index()
    {
        $passports = Passport::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $passports], 200);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $validationResult = $this->validateCreateData($request, null);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request);
            $data->fill($data->toArray());
            $data->save();
            DB::commit();
            return response()->json(['status' => 201, 'message' => 'Passport created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport created fail'], 400);
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
            $data = $this->getCreateData($request);
            $passports = Passport::findOrFail($id);
            $passports->fill($data->toArray());
            $passports->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Passport updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $passports = Passport::findOrFail($id);
            $passports->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Passport deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Passport deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $userid = auth()->user()->id;
        $data['passport_code_id'] = $request->passport_code_id;
        $data['issue_date'] = $request->issue_date;
        $data['expire_date'] = $request->expire_date;
        $data['passport_number'] = $request->passport_number;
        $data['user_id'] = $userid;
        return new Passport($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'passport_code_id' => 'required|integer',
            'issue_date' => 'required|date_format:Y.m.d',
            'expire_date' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $issueDate = \DateTime::createFromFormat('Y.m.d', $request->input('issue_date'));
                    $expireDate = \DateTime::createFromFormat('Y.m.d', $value);

                    if ($issueDate > $expireDate) {
                        $fail('The expire date cannot be less than the issue date.');
                    }
                },
            ],
            'passport_number' => [
                'required',
                Rule::unique('passports')->ignore($id)
            ]
        ], [
            'passport_code_id.required' => 'Passport Code is required.',
            'passport_number.required' => 'Passport number is required.',
            'passport_number.unique ' => 'Passport Number is already exists',
            'issue_date.required' => 'Passport Issue date is required',
            'issue_date.date_format' => 'Passport Issue date must be in the format YYYY.MM.DD.',
            'expire_date.required' => 'Passport Expiry date is required.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
