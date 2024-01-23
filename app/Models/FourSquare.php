<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FourSquare extends Model
{
    use HasFactory;
    protected $table = 'four_squares';
    protected $fillable = [
        'total_records',
        'current_latitude',
        'current_longitude',
        'current_limit'
    ];
}
