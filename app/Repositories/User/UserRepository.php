<?php 

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Core\CoreRepository;

class UserRepository extends CoreRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function allUsers($column, $any ,$value, $params = [])
    {
        return $this->model()->where($column, $any ,$value)->get($params)->toArray();
    }

    public function users($column, $any ,$value, $params = [],$column1,$value1)
    {
        return $this->model()->where($column, $any ,$value)
        ->where($column1,$value1)->get($params)->toArray();
    }

    public function allFriends($column,$params = [],$data = [])
    {
        return $this->model()->select($data
        )->whereIn($column,$params)->get()->toArray();
    }

    public function allFriendsForSearch($column,$params = [],$data = [],$column1,$value1,$column2)
    {
        return $this->model()->select($data
        )->whereNotIn($column,$params)
        ->where(function($query) use ($column1,$value1,$column2){
            $query->where($column1, 'like' ,'%'.$value1.'%')
            ->orWhere($column2, 'like' ,'%'.$value1.'%')
            ->orWhereRaw("concat(". $column1 .", ' ',". $column2 . ") like '%".$value1."%' ")
            ->orWhereRaw("concat(". $column2 .", ' ',". $column1 . ") like '%".$value1."%' ");
        })
        ->where('user_type','normal')
        ->get()->toArray();
    }

    public function spotPost($relation = [],$select=[],$column1,$value1)
    {
        return $this->model()
        ->select($select)
        ->with($relation)
        ->where($column1,$value1)
        ->get()->toArray();
    }

    public function userInterest($value,$column1,$value1)
    {
        return $this->model()
        ->select('id')
        ->where($column1,$value1)
        ->whereRaw('FIND_IN_SET(?,user_interests)',[$value])
        ->get()->toArray();
    }

    public function suggestions($select = [],$column,$ids=[])
    {
        return $this->model()
        ->select($select)
        ->whereIn($column,$ids)
        ->get()->toArray();
    }

    public function findFriends($select = [],$column1,$value1,$column2)
    {
        return $this->model()
        ->select($select)
        ->where(function($query) use ($column1,$value1,$column2){
            $query->where($column1, 'like' ,'%'.$value1.'%')
            ->orWhere($column2, 'like' ,'%'.$value1.'%')
            ->orWhereRaw("concat(". $column1 .", ' ',". $column2 . ") like '%".$value1."%' ")
            ->orWhereRaw("concat(". $column2 .", ' ',". $column1 . ") like '%".$value1."%' ");
        })->get()->toArray();
    }

    public function authUser($relation = [],$column1,$value1)
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->get()->toArray();
    }


    public function findForFriends($select = [],$column1,$value1,$column2,$column3,$value3,$column4,$value4,$value5)
    {
        return $this->model()
        ->select($select)
        ->whereHas('fromFriendsRelation',function($q) use ($value3,$value5){ 
            $q->where('to_user_id',$value3)->where('relation_status',$value5);
        })
        ->orWhereHas('toFriendsRelation',function($q) use ($value3,$value5){ 
            $q->where('from_user_id',$value3)->where('relation_status',$value5);
        })
        ->where(function($query) use ($column1,$value1,$column2){
            $query->where($column1, 'like' ,'%'.$value1.'%')
            ->orWhere($column2, 'like' ,'%'.$value1.'%')
            ->orWhereRaw("concat(". $column1 .", ' ',". $column2 . ") like '%".$value1."%' ")
            ->orWhereRaw("concat(". $column2 .", ' ',". $column1 . ") like '%".$value1."%' ");
        })
        ->where($column3,'!=',$value3)
        ->where($column4,$value4)
        ->get()->toArray();
    }

    public function twoWhere($column1,$value1,$column2,$value2,$select =[])
    {
        return $this->model()
        ->select($select)
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get()->toArray();
    }
}
