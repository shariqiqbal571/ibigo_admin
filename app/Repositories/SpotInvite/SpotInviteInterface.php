<?php 

namespace App\Repositories\SpotInvite;

use App\Repositories\Core\CoreInterface;

interface SpotInviteInterface extends CoreInterface{
    public function threeWhere($column1,$value1,$column2,$value2,$column3,$value3);
}