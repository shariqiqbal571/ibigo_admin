<?php 

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Core\CoreRepository;
use DB;

class PostRepository extends CoreRepository implements PostInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function get($column,$key,$value,$params = [])
    {
        return $this->model()->where($column,$key,$value)->get($params)->toArray();
    }

    public function relationPost($relation = [],$column,$id = [])
    {
        return $this->model()->whereIn($column,$id)->with($relation)->get()->toArray();
        
    }

    public function wherePost($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }

    public function post($relation = [],$column1,$operator,$value1,$column2,$value2 = [],$table,$value3)
    {
        if($column1 == 'group_id' || $column1 == 'event_id' || $column1 == 'spot_id')
        {
            return $this->model()
            ->with($relation)
            ->where($column1,$operator,$value1)
            ->whereIn($column2,$value2)
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
        }
        else
        {
            return $this->model()
            ->with($relation)
            ->where($column1,$operator,$value1)
            ->whereIn($column2,$value2)
            ->where('group_id',$value1)
            ->where('event_id',$value1)
            ->where('spot_id',$value1)
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();

        }
    }

    public function userPost($relation = [],$column1,$column2,$column3,$value1,$column,$value = [],$table,$value3)
    {
        return $this->model()
        ->with($relation)
        ->whereIn($column,$value)
        ->where($column1,$value1)
        ->where($column2,$value1)
        ->where($column3,$value1)
        ->whereHas($table,function ($query) use ($table,$column,$value1){
            $query->where($table,1)->where($column,$value1);
        })
        ->orWhereHas($table,function ($query) use ($table,$column,$value3){
            $query->where($table,2)->where($column,$value3);
        })
        ->orWhereHas($table,function ($query2) use ($table,$column,$value1){
            $query2->where($table,0)->where($column,$value1);
        })
        ->where($column1,$value1)
        ->where($column2,$value1)
        ->where($column3,$value1)
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function businessPost($relation = [],$table,$column1,$value1,$column2,$value2 = [],$table2,$value3)
    {
        return $this->model()
        ->with($relation)
        ->whereIn($column2,$value2)
        ->whereHas($table2,function($query) use ($table2,$column2){
            $query->where($table2,1)->where($column2,null);
        })
        ->orWhereHas($table2,function ($query1) use ($table2,$column2,$value3){
            $query1->where($table2,2)->where($column2,$value3);
        })
        ->orWhereHas($table2,function ($query2) use ($table2,$column2){
            $query2->where($table2,0)->where($column2,null);
        })
        ->orWhere($column2,$value3)
        ->where($table,function ($query3) use ($column1,$value1)
        {
            $query3->where($column1,$value1);
        })
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function postForUserProfile($relation=[],$select=[],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->select($select)
        ->where($column,$value)
        ->get()->toArray();
    }

    public function homePost($column1,$value1)
    {
        return $this->model()
        ->whereIn($column1,$value1)
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
    }

    public function getAllPostHome($relation = [],$column2,$value2 = [],$table,$column,$column1,$column3,$value1,$value3,$skip,$take)
    {
        return $this->model()
        ->with($relation)
        ->whereIn($column2,$value2)
        ->where(function ($q) use ($column1,$column3,$value1)
        {
            $q->where($column1,$value1)->where($column3,$value1);
        })
        ->where(function ($q) use ($table,$column,$value1,$value3){
            $q->whereHas($table,function ($query) use ($table,$column,$value1){
                $query->where($table,1)->where($column,$value1);
            })
            ->orWhereHas($table,function ($query) use ($table,$column,$value3){
                $query->where($table,2)->where($column,$value3);
            })
            ->orWhereHas($table,function ($query2) use ($table,$column,$value1){
                $query2->where($table,0)->where($column,$value1);
            });
        })
        ->orWhere($column,$value3)
        ->where(function ($q2) use ($column1,$column3,$value1)
        {
            $q2->where($column1,$value1)->where($column3,$value1);
        })
        ->orderBy('created_at', 'DESC')
        // ->paginate(25)
        ->offset($skip)
        ->limit($take)
        ->get();
    }

    public function getAllGroupPosts($column1,$column2,$value1,$relation = [])
    {
        return $this->model()
        ->with($relation)
        ->where(function ($q1) use ($column1,$column2,$value1){
            $q1->where($column1,$value1)->orWhereRaw("FIND_IN_SET($value1, $column2)");
        })->orderBy('id','DESC')->get()->toArray();
    }

}
