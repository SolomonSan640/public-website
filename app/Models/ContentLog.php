<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "service_id",
        "profile_id",
        "contact_id",
        "home_id",
        "about_id",
        "created_by",
        "updated_by",
        "status",
    ];
}
