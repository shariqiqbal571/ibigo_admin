<?php 

namespace App\Repositories\FriendRelation;

use App\Repositories\Core\CoreInterface;

interface FriendRelationInterface extends CoreInterface{
    public function friendRelation($column1, $value1,$column2, $value2);
    public function getFriends($column1,$column2,$column3,$value1,$value2);
    public function getFriendPost($column1,$column2,$column3,$value1,$value2);
    public function friendOfFriends($column1,$column2,$column3,$value1,$value2 = []);
    public function friendsOrNot($column1,$column2,$column3,$value1,$value2);
    public function twoWhere($column1,$value1,$column2,$value2);
}