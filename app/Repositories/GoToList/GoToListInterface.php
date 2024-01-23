<?php 

namespace App\Repositories\GoToList;

use App\Repositories\Core\CoreInterface;

interface GoToListInterface extends CoreInterface{
    public function oldGoToList($column2,$row2,$column1,$value1);
    public function relationWithSpot($relation = [],$table,$column1,$value1,$column2,$value2,$column3 = []);
    public function relationWithSingleSpot($relation = [],$table,$column1,$value1,$column2,$value2,$column3 = [],$id);
    public function whereTwo($column1,$value1,$column2,$value2);
}