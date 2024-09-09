<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "shop_id",
        "product_id",
        "created_by",
        "updated_by",
        "status",
    ];
}
