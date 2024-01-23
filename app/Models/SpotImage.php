<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotImage extends Model
{
    use HasFactory;
    protected $table = 'spot_images';
    protected $fillable = [
        'spot_id',
        'images'
    ];
}
