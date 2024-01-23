<?php 

namespace App\Repositories\GroupUser;

use App\Models\GroupUser;
use App\Repositories\Core\CoreRepository;

class GroupUserRepository extends CoreRepository implements GroupUserInterface
{
    public function __construct(GroupUser $model)
    {
        parent::__construct($model);
    }

    public function sendData($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }

    public function delete($column,$value)
    {
        return $this->model()->where($column,$value)->delete();
    }

    public function invitedFriends($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->where($column3,$value3)->get()->toArray();
    }

    public function relationalGroup($relation = [],$column1,$value1,$column2,$value2)
    {
        return $this->model()->with($relation)->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }
    
    public function updateGroup($column1,$value1,$column2,$value2,$update=[])
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->update($update);
    }

    public function removeUser($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->delete();
    }

    public function pendingGroups($relation = [],$column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->orderBy($column3,$value3)
        ->get()->toArray();
    }
}
