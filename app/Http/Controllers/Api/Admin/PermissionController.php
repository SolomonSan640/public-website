<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permissions::orderBy('updated', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $permissions], 200);
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
            return response()->json(['status' => 201, 'message' => 'Permissions created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Permissions created fail'], 400);
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
            $permissions = Permissions::findOrFail($id);
            $permissions->fill($data->toArray());
            $permissions->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Permissions updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Permissions updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $permissions = Permissions::findOrFail($id);
            $permissions->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Permissions deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Permissions deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data['name'] = $request->name;
        $data['key'] = $request->key;
        $data['group'] = $request->group;
        $data['description'] = $request->description;

        return new Permissions($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'key' => [
                'required',
                Rule::unique('permissions')->whereNull('deleted_at')->ignore($id),
            ],
            'group' => 'required',
        ], [
            'key.required' => 'Permissions is required.',
            'key.unique' => 'Permissions is already taken',
            'group.required' => 'Permission group is required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
