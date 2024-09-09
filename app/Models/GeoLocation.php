<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeoLocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "priority_layer_id",
        "start_latitude",
        "end_latitude",
        "start_longitude",
        "end_longitude",
        "created_by",
        "updated_by",
        'status'
    ];
}
