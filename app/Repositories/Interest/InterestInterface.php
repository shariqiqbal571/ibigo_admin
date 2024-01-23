<?php 

namespace App\Repositories\Interest;

use App\Repositories\Core\CoreInterface;

interface InterestInterface extends CoreInterface{
    public function getImages();

    public function getData($column1,$value1,$column2,$value2,$value3);
    public function findInterest($column,$value);
    public function authInterest($column,$value=[],$select=[]);
}