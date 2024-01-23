<?php 

namespace App\Repositories\Planning;

use App\Models\Planning;
use App\Repositories\Core\CoreRepository;

class PlanningRepository extends CoreRepository implements PlanningInterface
{
    public function __construct(Planning $model)
    {
        parent::__construct($model);
    }

    public function getPlans($relation = [],$column,$value)
    {
        return $this->model->with($relation)
        ->where($column,$value)->get()->toArray();
    }
}
