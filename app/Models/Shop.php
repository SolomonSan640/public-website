<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "country_id",
        "city_id",
        "township_id",
        "postal_code_id",
        "zip_code_id",
        "name_en",
        "name_mm",
        "name_th",
        "name_kr",
        "address",
        "open_time",
        "close_time",
        "description",
        "remark",
        "created_by",
        "updated_by",
        "status",
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function postalCode()
    {
        return $this->belongsTo(PostalCode::class);
    }

    public function zipCode()
    {
        return $this->belongsTo(ZipCode::class);
    }

    public function UserShop()
    {
        return $this->belongsTo(UserShop::class);
    }
}
