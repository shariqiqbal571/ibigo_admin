<?php 

namespace App\Repositories\Chat;

use App\Models\Chat;
use App\Repositories\Core\CoreRepository;

class ChatRepository extends CoreRepository implements ChatInterface
{
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    public function messages($column1,$column2,$value1,$value2,$column3,$value3)
    {
        return $this->model()
        ->where(function ($q) use ($column1, $column2, $value1, $value2){
            $q->where(function ($query1) use ($column1, $column2, $value1, $value2)
            {
                $query1->where($column1,$value2)->where($column2,$value1);
            })
            ->orWhere(function ($query2) use ($column1, $column2, $value1, $value2)
            {
                $query2->where($column1,$value1)->where($column2,$value2);
            });
        })
        ->where(function ($q2) use ($value2){
            $q2->whereRaw('FIND_IN_SET("'.$value2.'",user_chat_delete) = 0')
            ->orWhere('user_chat_delete',null);
        })
        ->orderBy($column3,$value3)
        ->get()->toArray();
    }

    public function recentChat($relation = [],$column1,$value1,$column2,$value2,$column3)
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->orderBy($column2,$value2)
        ->get()
        ->groupBy($column3)
        ->toArray();
    }

    public function recentFriends($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()
        ->where(function ($query1) use ($column3, $column1, $value3){
            $query1->where($column3,$value3)->orWhere($column1,$value3);
        })
        ->where(function ($q2) use ($value1){
            $q2->whereRaw('FIND_IN_SET("'.$value1.'",user_chat_delete) = 0')
            ->orWhere('user_chat_delete',null);
        })
        ->orderBy($column2,$value2)
        ->get()
        ->unique($column3)
        ->groupBy($column3)->groupBy($column1)
        ->toArray();
    }

    public function groupOrUser($relation = [],$column1,$column2,$value1,$value2)
    {
        return $this->model()
        ->with($relation)
        ->where(function ($query1) use ($column1, $column2, $value1, $value2)
        {
            $query1->where($column1,$value2)->where($column2,$value1);
        })
        ->orWhere(function ($query2) use ($column1, $column2, $value1, $value2)
        {
            $query2->where($column1,$value1)->where($column2,$value2);
        })
        ->get()->toArray();
    }

    public function read($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->where($column3,$value3)
        ->get()->toArray();
    }

    public function readMessages($column1,$value1,$column2,$value2,$params = [])
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->update($params);
    }

    public function unreadMessage($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->orderBy($column3,$value3)
        ->get()->toArray();
    }

}
