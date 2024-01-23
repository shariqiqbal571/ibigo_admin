<?php 

namespace App\Repositories\FriendRelation;

use App\Models\FriendRelation;
use App\Repositories\Core\CoreRepository;

class FriendRelationRepository extends CoreRepository implements FriendRelationInterface
{
    public function __construct(FriendRelation $model)
    {
        parent::__construct($model);
    }

    public function friendRelation($column1, $value1,$column2, $value2)
    {
        return $this->model()->where(
            function($query1) use ($column1,$column2,$value1,$value2)
            {
                $query1->where($column1,$value1)->where($column2,$value2);
            }
        )->orWhere(
            function($query2) use ($column1,$column2,$value1,$value2)
            {
                $query2->where($column1,$value2)->where($column2,$value1);
            }
        )->get()->toArray();
    }

    public function getFriends($column1,$column2,$column3,$value1,$value2)
    {
        return $this->model()->where(
            function ($query1) use ($column1,$column2,$value1,$value2)
            {
                $query1->where($column1,$value1)->where($column2,$value2);
            }
        )->orWhere(
            function ($query2) use ($column3,$column2,$value1,$value2)
            {
                $query2->where($column3,$value1)->where($column2,$value2);
            }
        )->get()->toArray();
    }

    public function getFriendPost($column1,$column2,$column3,$value1,$value2)
    {
        return $this->model()->where(
            function ($query1) use ($column1,$column2,$value1,$value2)
            {
                $query1->whereIn($column1,$value1)->where($column2,$value2);
            }
        )->orWhere(
            function ($query2) use ($column3,$column2,$value1,$value2)
            {
                $query2->whereIn($column3,$value1)->where($column2,$value2);
            }
        )->get()->toArray();
    }

    public function friendOfFriends($column1,$column2,$column3,$value1,$value2 = [])
    {
        return $this->model()
        ->select($column1,$column2,$column3)
        ->inRandomOrder()
        ->where(function ($query) use ($column1,$column2,$value2) {
            $query->whereIn($column1, $value2)->orWhereIn($column2, $value2)->get();
        })
        ->where($column1,'!=',$value1)
        ->where($column2,'!=',$value1)
        ->where($column3,1)
        ->limit(50)->get()->toArray();
    }

    public function friendsOrNot($column1,$column2,$column3,$value1,$value2)
    {
        return $this->model()
        ->select($column1,$column2,$column3)
        ->where(function ($query) use ($column1,$column2,$value1,$value2) {
            $query->where($column1, $value1)
            ->where($column2, $value2)->get();
        })
        ->where(function ($query2) use ($column3) {
            $query2->where($column3,0)
            ->orWhere($column3,1)->get();
        })->get()->toArray();

    }

    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)->where($column2,$value2)
        ->get()->toArray();
    }


}
