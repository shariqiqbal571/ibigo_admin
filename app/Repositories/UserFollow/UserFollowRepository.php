<?php 

namespace App\Repositories\UserFollow;

use App\Models\UserFollow;
use App\Repositories\Core\CoreRepository;

class UserFollowRepository extends CoreRepository implements UserFollowInterface
{
    public function __construct(UserFollow $model)
    {
        parent::__construct($model);
    }

    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get()->toArray();
    }

    public function unfollowFollow($column1,$value1,$column2,$value2,$data=[])
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->update($data);
    }
}
