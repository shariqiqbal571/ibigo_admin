<?php 

namespace App\Repositories\SpotInvite;

use App\Models\SpotInvite;
use App\Repositories\Core\CoreRepository;

class SpotInviteRepository extends CoreRepository implements SpotInviteInterface
{
    public function __construct(SpotInvite $model)
    {
        parent::__construct($model);
    }

    public function threeWhere($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->where($column3,$value3)->get()->toArray();
    }
}
