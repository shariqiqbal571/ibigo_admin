<?php 

namespace App\Repositories\Group;

use App\Models\Group;
use App\Repositories\Core\CoreRepository;

class GroupRepository extends CoreRepository implements GroupInterface
{
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function groupIndex($params = [],$relation = [])
    {
        return $this->model()->with($relation)->get($params)->toArray();
    }

    public function groupShow($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }

    public function updateGroup($id,$params = [],$column)
    {
        return $this->model()->where($column,$id)->update($params);
    }

    public function getGroupPost($column1,$value1 = [],$params = [])
    {
        return $this->model()->whereIn($column1,$value1)->get($params)->toArray();
    }
    
    public function searchGroup($params = [],$column,$value)
    {
        return $this->model()
        ->select($params)
        ->where($column, 'like' ,'%'.$value.'%')
        ->get()->toArray();
    }
    public function searchGroups($params = [],$relation = [],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($params)
        ->where($column, 'like' ,'%'.$value.'%')
        ->get()->toArray();
    }
    
    public function showGroup($column,$value,$relation=[])
    {
        return $this->model()
        ->with($relation)
        ->where($column,$value)
        ->get()->toArray();
    }

    public function showAllGroups($relation=[],$column1,$value1,$column2,$value2,$table)
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->orWhereHas($table,function($query) use ($column1,$value1,$column2,$value2)
        {
            $query->where($column1,$value1)->where($column2,$value2);
        })
        ->get()->toArray();
    }

    public function getGroupDetail($relation=[],$column1,$value1,$table)
    {
        return $this->model()
        ->with($relation)
        // ->where(function ($query) use ($table,$column1, $value1){
        //     $query->where($column1,$value1)
        //     ->orWhereHas($table,function ($query2) use ($value1){
        //         $query2->whereRaw("FIND_IN_SET($value1,shared_group_id)");
        //     });
        // })
        ->where($column1,$value1)
        ->get()->toArray();
    }
}
