<?php 

namespace App\Repositories\Planning;

use App\Repositories\Core\CoreInterface;

interface PlanningInterface extends CoreInterface{
    public function getPlans($relation = [],$column,$value);
}