<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->get();
        return response()->json(['status' => 200, 'data' => $roles], 200);
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
            return response()->json(['status' => 201, 'message' => 'Role created successfully'], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Role created fail'], 400);
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
            $roles = Role::findOrFail($id);
            $roles->fill($data->toArray());
            $roles->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Role updated successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Role updated fail'], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // $decryptId = decrypt($id);
            $roles = Role::findOrFail($id);
            $roles->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Role deleted successfully'], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Role deleted fail'], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['type'] = $request->type;

        return new Role($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('roles')->whereNull('deleted_at')->ignore($id),
            ],
        ], [
            'name.required' => 'Role name is required.',
            'name.unique' => 'Role Name is already taken',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }
}
