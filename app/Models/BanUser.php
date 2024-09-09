<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BanUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "image_id",
        "user_id",
        // "admin_id",
        "reason",
        "duration",
        "type",
        "start_time",
        "end_time",
        "start_date",
        "end_date",
        "created_by",
        "updated_by",
        "status",
    ];
}
