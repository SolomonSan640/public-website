<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "key",
        "group",
        "description",
        "created_by",
        "updated_by",
        "status",
    ];


    public function accounts () {
        return $this->hasMany(Admin::class, 'role', 'id');
    }
}
