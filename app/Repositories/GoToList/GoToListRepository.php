<?php 

namespace App\Repositories\GoToList;

use App\Models\GoToList;
use App\Repositories\Core\CoreRepository;

class GoToListRepository extends CoreRepository implements GoToListInterface
{
    public function __construct(GoToList $model)
    {
        parent::__construct($model);
    }

    public function oldGoToList($column2,$row2,$column1,$value1)
    {
        return $this->model()
        ->where($column2,$row2)
        ->where($column1,$value1)
        ->delete();
    }

    public function relationWithSpot($relation = [],$table,$column1,$value1,$column2,$value2,$column3 = [])
    {
        return $this->model()
        ->with($relation)
        // ->whereHas($table,function($query) use ($column1,$value1,$column2,$value2)
        // {
        //     $query->where($column1,'!=',$value1)->orWhere($column2,$value2);
        // })
        ->where($column1,$value1)
        ->get($column3)->toArray();
    }
    

    public function relationWithSingleSpot($relation = [],$table,$column1,$value1,$column2,$value2,$column3 = [],$id)
    {
        return $this->model()
        ->with($relation)
        ->whereHas($table,function($query) use ($column1,$value1,$column2,$value2)
        {
            $query->where($column1,'!=',$value1)->where($column2,$value2);
        })
        ->where('id',$id)
        ->get($column3)->toArray();
    }

    public function whereTwo($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get()->toArray();
    }

}
