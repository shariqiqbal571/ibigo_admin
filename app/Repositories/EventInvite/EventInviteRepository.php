<?php 

namespace App\Repositories\EventInvite;

use App\Models\EventInvite;
use App\Repositories\Core\CoreRepository;

class EventInviteRepository extends CoreRepository implements EventInviteInterface
{
    public function __construct(EventInvite $model)
    {
        parent::__construct($model);
    }
    
    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }
}
