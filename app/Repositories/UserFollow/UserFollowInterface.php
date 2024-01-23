<?php 

namespace App\Repositories\UserFollow;

use App\Repositories\Core\CoreInterface;

interface UserFollowInterface extends CoreInterface{
   public function twoWhere($column1,$value1,$column2,$value2);
   public function unfollowFollow($column1,$value1,$column2,$value2,$data=[]);
}