<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "second_label_id",
        "city_id",
        "name",
        "created_by",
        "updated_by",
        'status'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function secondLabel()
    {
        return $this->belongsTo(SecondLabel::class)->select('id', 'name');
    }
}
