<?php 

namespace App\Repositories\User;

use App\Repositories\Core\CoreInterface;

interface UserInterface extends CoreInterface{
    public function allUsers($column, $any ,$value, $params = []);
    public function users($column, $any ,$value, $params = [],$column1,$value1);
    public function allFriends($column,$params = [],$data = []);
    public function allFriendsForSearch($column,$params = [],$data = [],$column1,$value1,$column2);
    public function spotPost($relation = [],$select=[],$column1,$value1);
    public function userInterest($value,$column1,$value1);
    public function suggestions($select = [],$column,$ids=[]);
    public function findFriends($select = [],$column1,$value1,$column2);            
    public function authUser($relation = [],$column1,$value1);
    public function findForFriends($select = [],$column1,$value1,$column2,$column3,$value3,$column4,$value4,$value5);
    public function twoWhere($column1,$value1,$column2,$value2,$select =[]);
}