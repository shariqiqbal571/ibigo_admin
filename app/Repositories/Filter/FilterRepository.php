<?php 

namespace App\Repositories\Filter;

use App\Models\Filter;
use App\Repositories\Core\CoreRepository;

class FilterRepository extends CoreRepository implements FilterInterface
{
    public function __construct(Filter $model)
    {
        parent::__construct($model);
    }

    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get()->toArray();
    }
}
