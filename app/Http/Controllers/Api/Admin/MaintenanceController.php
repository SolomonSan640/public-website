<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Throwable;


class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenance = Maintenance::value('switch');
        $data = ($maintenance === 1) ? true : false;
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        // $this->setLocale(strtolower('en'));
        // $validationResult = $this->validateCreateData($request, null);
        // if ($validationResult !== null) {
        //     return $validationResult;
        // }
        try {
            $data = $this->getCreateData($request);
            $maintenance = Maintenance::first();

            if ($maintenance) {
                $maintenance->switch = $data->switch;
                $maintenance->update();
            } else {
                $maintenance = new Maintenance();
                $maintenance->fill($data->toArray());
                $maintenance->save();
            }
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'Maintenance'])], 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'Maintenance'])], 400);
        }
    }

    protected function getCreateData($request)
    {
        $data = [];

        $data['switch'] = $request->switch;

        return new Maintenance($data);
    }
}
