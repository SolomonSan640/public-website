<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\NrcNo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NrcNoController extends Controller
{
    public function index()
    {
        $nrcno = NrcNo::with('nrc_type.nrc_township.township', 'nrc_type.nrc_township.nrc_code')->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $nrcno], 200);
    }

    public function create()
    {
    }
}
