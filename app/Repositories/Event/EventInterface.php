<?php 

namespace App\Repositories\Event;

use App\Repositories\Core\CoreInterface;

interface EventInterface extends CoreInterface{
    public function event($relation = [],$column1,$value1);
    public function searchEvent($relation = [],$column1,$value1,$column2,$value2);
    public function twoWhere($column1,$value1,$column2,$value2);
    public function currentEvents($column1,$value1);
}