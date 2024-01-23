<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoToList extends Model
{
    use HasFactory;
    protected $table = 'go_to_lists';
    protected $fillable = [
        'user_id',
        'spot_id',
        'is_liked'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select
        ([
            'id',
            'unique_id',
            'user_slug',
            'user_profile',
            DB::raw("CONCAT(first_name,' ',last_name) AS user_name")
        ]);
    }

    public function spot()
    {
        return $this->belongsTo('App\Models\Spot','spot_id','id')
        ->select([
            'id',
            'user_id',
            'spot_profile',
            'latitude',
            'longitude',
            'business_name',
            'short_description',
            'rating',
            'business_type',
            DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
        ]);
    }
}
