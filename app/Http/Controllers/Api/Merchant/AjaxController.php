<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Models\City;
use App\Models\Country;
use App\Models\Township;
use App\Models\NrcTownship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function townshipCity($city)
    {
        $townships = Township::where('city_id', $city)->get();

        if ($townships->isEmpty()) {
            return response()->json(['error' => 'No townships found for the provided city.'], 404);
        }

        return response()->json(['message' => 'Townships found.', 'data' => $townships], 200);
    }

    public function cityCountry($country)
    {
        $cities = City::where('country_id', $country)->with('timezone')->get();

        if ($cities->isEmpty()) {
            return response()->json(['message' => 'Cities found.', 'data' => $cities], 200);
        }

        return response()->json(['message' => 'Cities found.', 'data' => $cities], 200);
    }

    public function nrcCode($codes)
    {
        $townshipId = NrcTownship::where('nrc_code_id', $codes)->get('township_id');

        $townships = [];
        foreach ($townshipId as $t_id) {
            $townships[] = Township::where('id', $t_id->township_id)->get();
        }
        
        if ($townshipId->isEmpty()) {
            return response()->json(['error' => 'No township found for the provided Nrc Code.'], 404);
        }

        return response()->json(['message' => 'township found.', 'data' => $townships], 200);
    }

    public function country()
    {
        $countries = Country::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $countries], 200);
    }

    public function city()
    {
        $cities = City::orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $cities], 200);
    }
}
