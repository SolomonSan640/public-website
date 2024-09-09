<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostalCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "township_id",
        "city_id",
        "name",
        "created_by",
        "updated_by",
        "status",
    ];

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
