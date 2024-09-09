<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "first_label_id",
        "country_id",
        "name",
        "start_latitude",
        "end_latitude",
        "start_longitude",
        "end_longitude",
        "created_by",
        "updated_by",
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function firstLabel()
    {
        return $this->belongsTo(FirstLabel::class)->select('id', 'name');
    }

    public function geo()
    {
        return $this->hasMany(ProvinceGeo::class);
    }
}
