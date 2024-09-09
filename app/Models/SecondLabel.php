<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecondLabel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "city_id",
        "name",
        "created_by",
        "updated_by",
        'status'
    ];

}
