<?php 

namespace App\Repositories\SpotDetail;

use App\Models\SpotDetail;
use App\Repositories\Core\CoreRepository;

class SpotDetailRepository extends CoreRepository implements SpotDetailInterface
{
    public function __construct(SpotDetail $model)
    {
        parent::__construct($model);
    }

    public function twoWhere($column1,$value1,$column2,$operator,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$operator,$value2)->get()->toArray();
    }

    public function checkUser($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }

    public function likeSpot($relation = [],$column1,$value1,$column3,$column2,$value2,$params = [])
    {
        return $this->model()->with($relation)->where(function ($query) use ($column1,$column3,$value1)
        {
            $query->where($column1,$value1)->orWhere($column3,$value1);
        })->where($column2,$value2)->get($params)->toArray();
    }

    public function likeUser($column1,$value1,$column2,$operator,$value2,$column3)
    {
        return $this->model()->select($column3)
        ->where($column1,$value1)
        ->where($column2,$operator,$value2)->get()->toArray();
    }

    public function ratings($raw,$column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()
        ->select($raw('sum('.$column1.') as '.$value1),
        $raw('count('.$column2.') as '.$value2))
        ->where($column3,$value3)->get()->toArray();
    }

    public function searchSpot($relation = [],$column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->where($column2,$value2)->get()->toArray();
    }

    public function topSpots($relation = [],$select = [],$column2,$operator,$value2,$value3,$desc)
    {
        return $this->model
        ->select($select)
        ->with($relation)
        ->where(function ($query) use ($column2,$operator,$value2,$value3){
            $query->where($column2,$operator,$value2)
            ->orWhere($column2,$operator,$value3);
        })
        ->orderBy($column2,$desc)
        ->get()->toArray();
    }

    public function userReviewSpots($column1,$value1,$column2,$value2,$limit)
    {
        return $this->model()
        ->where($column1,$value1)
        ->orderBy($column2,$value2)
        ->limit($limit)
        ->get()->toArray();
    }

    public function spotForUserProfile($relation = [],$select=[],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->where($column,$value)
        ->get()->toArray();
    }
}
