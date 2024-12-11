<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
protected $table = 'songs';

    protected $fillable = [
        'user_id',
        'youtube_url',
        'title',
        'artist',
        'file_name',
        'thumbnail_url',
        'duration',
        'download_status'
    ];
}
