<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $fillable = [
        'user_id',
        'subscription_id',
        'customer_id',
        'mandate_id',
        'subscription_date',
        'subscription_status'
    ];
}
