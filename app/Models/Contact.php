<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "contact_status_id",
        "email",
        "phone",
        "message",
        "created_by",
        "updated_by",
        "status",
    ];

    protected $casts = [
        "phone" => "json",
        "message" => "json",
    ];

    public function contactStatus()
    {
        return $this->belongsTo(ContactStatus::class);
    }
}
