<?php 

namespace App\Repositories\Interest;

use App\Models\Interest;
use App\Repositories\Core\CoreRepository;

class InterestRepository extends CoreRepository implements InterestInterface
{
    public function __construct(Interest $model)
    {
        parent::__construct($model);
    }

    public function getImages(){
        return $this->model()->get(['id','title','image']);
    }

    public function getData($column1,$value1,$column2,$value2,$value3)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where(function($query) use ($column2,$value2,$value3)
        {
            $query->where($column2,$value2)->orWhere($column2,$value3);
        })
        ->get()->toArray();
    }

    public function findInterest($column,$value)
    {
        return $this->model()
        ->where($column, 'like' ,"%".$value."%")
        ->get()->toArray();
    }

    public function authInterest($column,$value=[],$select=[])
    {
        return $this->model()
        ->select($select)
        ->whereIn($column,$value)
        ->get()->toArray();
    }
}
