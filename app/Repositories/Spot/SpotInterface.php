<?php 

namespace App\Repositories\Spot;

use App\Repositories\Core\CoreInterface;

interface SpotInterface extends CoreInterface{
    public function getRelation($relation = [],$params = [],$column,$value);
    public function otherSpots($relation = [],$column,$value = [],$params = []);
    public function findSpot($relation = [],$select = [],$column1,$column2,$column3,$column4,$value);
    public function findSpotWho($relation = [],$select = [],$column1,$value);
    public function spotSuggestions($relation = [],$select = [],$column,$value);
    public function topRatedSpots($relation = [],$select = [],$column,$value =[],$limit);
    public function recentSpots($relation = [],$select = [],$limit,$column2,$value2,$column1,$value1 = []);
    public function sushiSpot($relation = [],$select = [],$column1,$column2,$column3,$column4,$value,$limit,$column5,$value5);
    public function searchWithTime($relation = [],$select = [],$column,$value1,$value2);
    public function searchWithMonth($relation = [],$select = [],$column,$value);
    public function searchWithWeekend($relation = [],$select = []);
    public function spotsOfInterest($relation=[],$column,$value);
}