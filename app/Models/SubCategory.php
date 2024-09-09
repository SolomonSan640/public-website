<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "category_id",
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryEn()
    {
        return $this->category()->select('id', 'name_en');
    }

    public function categoryMm()
    {
        return $this->category()->select('id', 'name_mm');
    }
}
