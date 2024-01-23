<?php 

namespace App\Repositories\PlanningInvitation;

use App\Repositories\Core\CoreInterface;

interface PlanningInvitationInterface extends CoreInterface{
    public function twoWhere($column1,$value1,$column2,$value2);
    public function twoWhereRelation($column1,$value1,$column2,$value2,$relation = []);
}