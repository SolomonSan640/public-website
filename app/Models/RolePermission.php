<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "role_id",
        "permission_id",
        "permission_level",
        "created_by",
        "updated_by",
        "status",
    ];
}
