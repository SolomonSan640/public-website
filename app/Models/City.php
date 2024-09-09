<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "country_id",
        "province_id",
        "timezone_id",
        "language_id",
        "second_label_id",
        "name",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];

    public function province()
    {
        return $this->belongsTo(Province::class)->select('id', 'name', 'first_label_id');
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class)->select('id', 'name');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function secondLabel()
    {
        return $this->belongsTo(SecondLabel::class)->select('id', 'name');
    }

    public function geo()
    {
        return $this->hasMany(CityGeo::class);
    }
}
