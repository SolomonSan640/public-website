<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "category_id",
        "sub_category_id",
        "image_id",
        "country_id",
        "currency_id",
        "name_en",
        "name_mm",
        "name_th",
        "name_kr",
        "sku",
        "unit",
        "price",
        "quantity",
        "description_en",
        "description_mm",
        "description_th",
        "description_kr",
        "remark_en",
        "remark_mm",
        "remark_th",
        "remark_kr",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function country() 
    {
        return $this->belongsTo(Country::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function images()
    {
        return $this->hasMany(GeneralImage::class);
    }

    public function categoryEn()
    {
        return $this->category()->select('id', 'name_en');
    }

    public function categoryMm()
    {
        return $this->category()->select('id', 'name_mm');
    }

    public function subCategoryEn()
    {
        return $this->category()->select('id', 'name_en');
    }

    public function subCategoryMm()
    {
        return $this->category()->select('id', 'name_mm');
    }

    public function countryEn()
    {
        return $this->country()->select('id', 'name_en');
    }

    public function countryMm()
    {
        return $this->country()->select('id', 'name_mm');
    }

    public function currencyEn()
    {
        return $this->currency()->select('id', 'name_en');
    }

    public function currencyMm()
    {
        return $this->currency()->select('id', 'name_mm');
    }

    public function productImage()
    {
        return $this->images()->select('id', 'product_id', 'file_path');
    }
}
