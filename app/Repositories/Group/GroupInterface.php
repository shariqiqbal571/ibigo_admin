<?php 

namespace App\Repositories\Group;

use App\Repositories\Core\CoreInterface;

interface GroupInterface extends CoreInterface{
    public function groupIndex($params = [],$relation = []);
    public function searchGroups($params = [],$relation = [],$column,$value);
    public function groupShow($column1,$value1,$column2,$value2);
    public function updateGroup($id,$params = [],$column);
    public function getGroupPost($column1,$value1 = [],$params = []);
    public function searchGroup($params = [],$column,$value);
    public function showGroup($column,$value,$relation=[]);
    public function showAllGroups($relation=[],$column1,$value1,$column2,$value2,$table);
    public function getGroupDetail($relation=[],$column1,$value1,$table);
}