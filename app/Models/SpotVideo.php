<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotVideo extends Model
{
    use HasFactory;
    protected $table = 'spot_videos';
    protected $fillable = [
        'spot_id',
        'videos'
    ];
}
