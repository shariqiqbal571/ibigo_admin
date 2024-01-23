<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsDetailImage extends Model
{
    use HasFactory;
    protected $table = 'cms_detail_images';
    protected $fillable = [
        'cms_detail_id',
        'images'
    ];
}
