<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicePageMM extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "title_1",
        "title_2",
        "title_3",
        "title_4",
        "title_5",
        "title_6",
        "title_7",
        "title_8",
        "title_9",
        "title_10",
        "content_1",
        "content_2",
        "content_3",
        "content_4",
        "content_5",
        "content_6",
        "content_7",
        "content_8",
        "content_9",
        "content_10",
        "image_1",
        "image_2",
        "image_3",
        "image_4",
        "image_5",
        "image_6",
        "image_7",
        "image_8",
        "image_9",
        "image_10",
        "image_m_1",
        "image_m_2",
        "image_m_3",
        "image_m_4",
        "image_m_5",
    ];
}
