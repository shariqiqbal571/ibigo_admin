<?php 

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\Core\CoreRepository;

class EventRepository extends CoreRepository implements EventInterface
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function event($relation = [],$column1,$value1)
    {
        return $this->model()->with($relation)->where($column1,$value1)->get()->toArray();
    }

    public function searchEvent($relation = [],$column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->with($relation)
        ->where($column1, 'like' ,'%'.$value1.'%')
        ->where($column2 ,'>',$value2)->get()->toArray();
    }

    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }

    public function currentEvents($column1,$value1)
    {
        return $this->model()
        ->where($column1 ,'>',$value1)->get()->toArray();
    }

}
