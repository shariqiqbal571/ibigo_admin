<?php 

namespace App\Repositories\Filter;

use App\Repositories\Core\CoreInterface;

interface FilterInterface extends CoreInterface{
    public function twoWhere($column1,$value1,$column2,$value2);
}