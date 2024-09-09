<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NrcNo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "nrc_type_id",
        "name_en",
        "name_mm",
        "created_by",
        "updated_by",
        "status",
    ];


    public function nrcType()
    {
        return $this->belongsTo(NrcType::class);
    }
}
