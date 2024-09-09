<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NrcTownship extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "township_id",
        "nrc_code_id",
        "created_by",
        "updated_by",
        "status",
    ];

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function nrcCode()
    {
        return $this->belongsTo(NrcCode::class);
    }
}
