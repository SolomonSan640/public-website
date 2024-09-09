<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "passport_code_id",
        "issue_date",
        "expire_date",
        "passport_number",
        "created_by",
        "updated_by",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function passportCode()
    {
        return $this->belongsTo(PassportCode::class);
    }
}
