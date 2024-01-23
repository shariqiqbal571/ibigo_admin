<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsDetail extends Model
{
    use HasFactory;
    protected $table = 'cms_details';
    protected $fillable = [
        'cms_id',
        'title',
        'description'
    ];

    public function cmsDetailImage()
    {
        return $this->hasMany('App\Models\CmsDetailImage','cms_detail_id','id');
    }

    public function cms()
    {
        return $this->belongsTo('App\Models\CMS','cms_id','id');
    }
}
