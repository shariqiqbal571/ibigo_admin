<?php 

namespace App\Repositories\PlanningInvitation;

use App\Models\PlanningInvitation;
use App\Repositories\Core\CoreRepository;

class PlanningInvitationRepository extends CoreRepository implements PlanningInvitationInterface
{
    public function __construct(PlanningInvitation $model)
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

    public function twoWhereRelation($column1,$value1,$column2,$value2,$relation = [])
    {
        return $this->model()
        ->with($relation)
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get()->toArray();
    }
}
