<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpertise extends Model
{
    use HasFactory;
    protected $table = 'user_expertises';
    protected $fillable = [
        'user_id',
        'expertise_id'
    ];

    public function expertise()
    {
        return $this->belongsTo('App\Models\Expertise','expertise_id','id')
        ->select('id','title','icon');
    }
}
