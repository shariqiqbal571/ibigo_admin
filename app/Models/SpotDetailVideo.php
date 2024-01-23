<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotDetailVideo extends Model
{
    use HasFactory;
    protected $table = 'spot_detail_videos';
    protected $fillable = [
        'spot_detail_id',
        'review_video'
    ];
}
