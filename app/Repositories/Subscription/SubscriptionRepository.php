<?php 

namespace App\Repositories\Subscription;

use App\Models\Subscription;
use App\Repositories\Core\CoreRepository;

class SubscriptionRepository extends CoreRepository implements SubscriptionInterface
{
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }
}
