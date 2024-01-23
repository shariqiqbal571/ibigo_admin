<?php 

namespace App\Repositories\SpotDetail;

use App\Repositories\Core\CoreInterface;

interface SpotDetailInterface extends CoreInterface{
    public function twoWhere($column1,$value1,$column2,$operator,$value2);
    public function likeSpot($relation = [],$column1,$value1,$column3,$column2,$value2,$params = []);
    public function likeUser($column1,$value1,$column2,$operator,$value2,$column3);
    public function ratings($raw,$column1,$value1,$column2,$value2,$column3,$value3);
    public function searchSpot($relation = [],$column1,$value1,$column2,$value2);
    public function topSpots($relation = [],$select = [],$column2,$operator,$value2,$value3,$desc);
    public function userReviewSpots($column1,$value1,$column2,$value2,$limit);
    public function spotForUserProfile($relation = [],$select=[],$column,$value);
    public function checkUser($column1,$value1,$column2,$value2);
}