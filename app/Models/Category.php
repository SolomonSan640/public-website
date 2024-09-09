<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "image_id",
        "name_en",
        "name_mm",
        "name_th",
        "name_kr",
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
}
