<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "notification_id",
        "user_id",
        // "admin_id",
        "is_read",
        "is_archieved",
        "created_by",
        "updated_by",
        "status",
    ];
}
