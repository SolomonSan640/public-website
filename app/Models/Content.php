<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "content_key_id",
        "name",
        "image_count",
        "content_count",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];

    public function contentKey()
    {
        return $this->belongsTo(ContentKey::class);
    }
}
