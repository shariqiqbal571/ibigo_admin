<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;
    protected $table = 'filters';
    protected $fillable = [
        'name',
        'slug',
        'unique_id',
        'type',
        'status',
        'category',
    ];
}
