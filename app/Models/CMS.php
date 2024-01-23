<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    use HasFactory;
    protected $table = 'c_m_s';
    protected $fillable = [
        'title','unique_id','slug','image'
    ];

    public function cmsDetail()
    {
        return $this->hasMany('App\Models\CmsDetail','cms_id','id');
    }
}
