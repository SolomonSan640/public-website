<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "type",
        "description",
        "read_at",
        "created_by",
        "updated_by",
        "status",
    ];
}
