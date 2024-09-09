<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "created_by",
        "updated_by",
        "status",
    ];
}
