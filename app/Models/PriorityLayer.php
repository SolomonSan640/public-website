<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriorityLayer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'layer_id',
        'priority_id',
        'name',
        'layer_priority_id',
        'is_show',
        'status',
        'created_by',
        'updated_by'
    ];

    public function layer()
    {
        return $this->belongsTo(Layer::class)->select('id', 'name');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class)->select('id', 'name');
    }

    public function pLayer()
    {
        return $this->belongsTo(PriorityLayer::class, 'id')->select('id', 'layer_id', 'priority_id', 'name', 'layer_priority_id');
    }

    public function cinfo()
    {
        return $this->hasOne(CountInfo::class)->select('id', 'priority_layer_id', 'iso2', 'iso3', 'currency', 'callcode', 'flag');
    }
}
