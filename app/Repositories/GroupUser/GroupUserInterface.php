<?php 

namespace App\Repositories\GroupUser;

use App\Repositories\Core\CoreInterface;

interface GroupUserInterface extends CoreInterface{
    public function sendData($column1,$value1,$column2,$value2);
    public function delete($column,$value);
    public function invitedFriends($column1,$value1,$column2,$value2,$column3,$value3);
    public function relationalGroup($relation = [],$column1,$value1,$column2,$value2);
    public function updateGroup($column1,$value1,$column2,$value2,$update=[]);
    public function removeUser($column1,$value1,$column2,$value2);
    public function pendingGroups($relation = [],$column1,$value1,$column2,$value2,$column3,$value3);
}