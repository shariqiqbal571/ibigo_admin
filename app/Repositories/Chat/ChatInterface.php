<?php 

namespace App\Repositories\Chat;

use App\Repositories\Core\CoreInterface;

interface ChatInterface extends CoreInterface{
    public function messages($column1,$column2,$value1,$value2,$column3,$value3);
    public function recentChat($relation = [],$column1,$value1,$column2,$value2,$column3);
    public function groupOrUser($relation = [],$column1,$column2,$value1,$value2);
    public function recentFriends($column1,$value1,$column2,$value2,$column3,$value3);
    public function read($column1,$value1,$column2,$value2,$column3,$value3);
    public function readMessages($column1,$value1,$column2,$value2,$params = []);
}