<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "content_id",
        "image_id",
        "title",
        "image_serial_number",
        "content_serial_number",
        "description",
        "file",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
