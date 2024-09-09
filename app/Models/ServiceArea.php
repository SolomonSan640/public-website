<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceArea extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "country_id",
        "regional_id",
        "first_label_id",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function regionalName()
    {
        return $this->regional()->select('id', 'name');
    }

    public function countryName()
    {
        return $this->country()->select('id', 'name');
    }

    public function countries()
    {
        return $this->country()->select('id', 'name');
    }

    public function firstLabel()
    {
        return $this->belongsTo(FirstLabel::class)->select('id', 'name');
    }
}
