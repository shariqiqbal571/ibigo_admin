<?php 

namespace App\Repositories\Spot;

use App\Models\Spot;
use App\Repositories\Core\CoreRepository;
use Illuminate\Support\Facades\DB;

class SpotRepository extends CoreRepository implements SpotInterface
{
    public function __construct(Spot $model)
    {
        parent::__construct($model);
    }

    public function getRelation($relation = [],$params = [],$column,$value)
    {
        if($value)
        {
            return $this->model()->with($relation)
            ->where($column,$value)
            ->get($params)->toArray();
        }
        else{
            return $this->model()->with($relation)
            ->get($params)->toArray();
        }
    }

    public function otherSpots($relation = [],$column,$value = [],$params = [])
    {
        return $this->model()
        ->select($params)
        ->with($relation)
        ->whereNotIn($column,$value)
        ->get()->toArray();
    }

    public function findSpot($relation = [],$select = [],$column1,$column2,$column3,$column4,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->where(function($query) use ($column1,$column2,$column3,$column4,$value){
            $query->where($column1, 'like' ,'%'.$value.'%')
            ->orWhereRaw("concat(". $column2 .", ' ',". $column3.", ' ',". $column4. ") like '%".$value."%' ");
        })
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function findSpotWho($relation = [],$select = [],$column1,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->where($column1, 'like' ,'%'.$value.'%')
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function spotSuggestions($relation = [],$select = [],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->orderBy($column,$value)
        ->get();
    }

    public function topRatedSpots($relation = [],$select = [],$column,$value =[],$limit)
    {
        return $this->model()
        ->select($select)
        ->with($relation)
        ->whereIn($column,$value)
        ->limit($limit)
        ->get()->toArray();
    }

    public function recentSpots($relation = [],$select = [],$limit,$column2,$value2,$column1,$value1 = [])
    {
        return $this->model
        ->select($select)
        ->with($relation)
        ->whereIn($column1,$value1)
        ->orderBy($column2,$value2)
        ->limit($limit)
        ->get()->toArray();
    }


    public function sushiSpot($relation = [],$select = [],$column1,$column2,$column3,$column4,$value,$limit,$column5,$value5)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->where(function($query) use ($column1,$column2,$column3,$column4,$value){
            $query->where($column1, 'like' ,'%'.$value.'%')
            ->orWhere($column2, 'like' ,'%'.$value.'%')
            ->orWhere($column3, 'like' ,'%'.$value.'%')
            ->orWhere($column4, 'like' ,'%'.$value.'%');
        })
        ->orderBy($column5,$value5)
        ->limit($limit)
        ->get()->toArray();
    }

    public function searchWithTime($relation = [],$select = [],$column,$value1,$value2)
    {
        return $this->model()
        ->select($select)
        ->with($relation)
        ->whereBetween(
            $column, [$value1, $value2]
        )
        ->orWhereBetween($column,[$value2,$value1])
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function searchWithMonth($relation = [],$select = [],$column,$value)
    {
        return $this->model()
        ->select($select)
        ->with($relation)
        ->whereMonth(
            $column,$value
        )
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function searchWithWeekend($relation = [],$select = [])
    {
        return $this->model()
        ->select($select)
        ->with($relation)
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function spotsOfInterest($relation=[],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->whereHas('userSpot',function($query) use ($column,$value){
            $query->whereRaw("find_in_set(".$value.",".$column.")");
        })
        ->get()->toArray();
    }
}
