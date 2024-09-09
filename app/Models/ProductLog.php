<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "product_id",
        // "admin_id",
        "old_price",
        "new_price",
        "description",
        "created_by",
        "updated_by",
        "status",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->select('id',  "name_en", "name_mm", "name_th", "name_kr",'unit', 'quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
