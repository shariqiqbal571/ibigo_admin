<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'spot_id',
        'group_id',
        'event_id',
        'checkin_id',
        'review_id',
        'planning_id',
        'title',
        'description',
        'shared_group_id',
        'shared_user_id',
        'tagged_user_id',
        'spot_review',
        'parent_id'
    ];

    public function sharedPost()
    {
        return $this->belongsTo('App\Models\Post','parent_id','id');
    }
    
    public function postImages()
    {
        return $this->hasMany('App\Models\PostImage','post_id','id');
    }

    public function postVideos()
    {
        return $this->hasMany('App\Models\PostVideo','post_id','id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\Models\PostAudio','post_id','id');
    }

    public function userPost()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(
            'id',
            'user_profile',
            'user_slug',
            'unique_id',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        );
    }

    public function spotPost()
    {
        return $this->belongsTo('App\Models\Spot','spot_id','id')
        ->select(['id','user_id','business_name','latitude','longitude','postal_code','street_no','city']);
    }

    public function reviewPost()
    {
        return $this->belongsTo('App\Models\SpotDetail','review_id','id');
    }

    public function planningPost()
    {
        return $this->belongsTo('App\Models\Planning','planning_id','id');
    }

    public function checkinPost()
    {
        return $this->belongsTo('App\Models\Spot','checkin_id','id')
        ->select(['id','user_id','business_name','latitude','longitude','short_description',DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")]);
    }

    public function groupPost()
    {
        return $this->belongsTo('App\Models\Group','group_id','id')
        ->select(['id','user_id','group_name','group_unique_id','group_slug']);
    }

    public function eventPost()
    {
        return $this->belongsTo('App\Models\Event','event_id','id')
        ->select(['id','event_title','event_slug','event_unique_id']);
    }

    public function sharedUser()
    {
        return $this->belongsTo('App\Models\User','shared_user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }

    public function taggedUser()
    {
        return $this->belongsTo('App\Models\User','tagged_user_id','id')
        ->select(['id','unique_id','first_name','last_name','user_slug','user_profile']);
    }

    public function sharedGroup()
    {
        return $this->belongsTo('App\Models\Group','shared_group_id','id');
    }

    public function postLike()
    {
        return $this->hasMany('App\Models\PostLike','post_id','id')
        ->where('like',1);
    }

    public function postComment()
    {
        return $this->hasMany('App\Models\PostComment','post_id','id');
    }

    public function status()
    {
        return $this->hasMany('App\Models\PostStatus','post_id','id');
    }
    
}
