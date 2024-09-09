<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Township extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "district_id",
        "city_id",
        "name",
        "short_name",
        "latitude",
        "longitude",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];


    public function city()
    {
        return $this->belongsTo(City::class)->select('id', 'name');
    }

    public function district()
    {
        return $this->belongsTo(District::class)->select('id', 'name');
    }

    public function geo()
    {
        return $this->hasMany(TownshipGeo::class)->select('id','township_id','start_latitude','end_latitude','start_longitude','end_longitude');
    }
}
