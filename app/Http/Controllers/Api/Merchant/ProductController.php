<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Models\Product;
use App\Models\ProductLog;
use App\Models\GeneralImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function product(Request $request)
    {
        $this->setLocale(strtolower($request->country));
        $columns = $this->getColumns(strtolower($request->country));
        if (strtolower($request->country) === "mm") {
            $products = Product::with('countryMm', 'currencyMm', 'productImage')->select($columns)->orderBy('updated_at', 'desc')->get();
        } else {
            $products = Product::with('countryEn', 'currencyEn', 'productImage')->select($columns)->orderBy('updated_at', 'desc')->get();
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $products], 200);
    }

    public function productLog(Request $request)
    {
        $this->setLocale(strtolower($request->country));
        $columns = $this->getLogs();
        if (strtolower($request->country) === "mm") {
            $productLogs = ProductLog::with('product')->orderBy('updated_at', 'asc')->select($columns)->get();
        } else {
            $productLogs = ProductLog::with('product')->orderBy('updated_at', 'asc')->select($columns)->get();
        }
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $productLogs], 200);

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
            return ['id', 'country_id', 'currency_id', 'name_mm', 'sku', 'quantity','unit' ,'price', 'description_mm', 'remark_mm', 'updated_at'];
        } else {
            return ['id', 'country_id', 'currency_id', 'name_en', 'sku', 'quantity', 'unit','price', 'description_en', 'remark_en', 'updated_at'];
        }
    }

    private function getLogs()
    {
        return ['id', 'product_id', 'old_price', 'new_price', 'updated_at'];
    }
}
