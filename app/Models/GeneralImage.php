<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        // "admin_id",
        "content_detail_id",
        "category_id",
        "sub_category_id",
        "product_id",
        "name",
        "file_path",
        "link",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];
}
