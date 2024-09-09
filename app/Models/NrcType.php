<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NrcType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name_en",
        "name_mm",
        "nrc_township_id",
        "created_by",
        "updated_by",
        "status",
    ];


    public function nrcTownship()
    {
        return $this->belongsTo(NrcTownship::class);
    }
}
