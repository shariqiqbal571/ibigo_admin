<?php 

namespace App\Repositories\EventInvite;

use App\Repositories\Core\CoreInterface;

interface EventInviteInterface extends CoreInterface{
    public function twoWhere($column1,$value1,$column2,$value2);
}