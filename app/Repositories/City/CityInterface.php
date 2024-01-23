<?php 

namespace App\Repositories\City;

use App\Repositories\Core\CoreInterface;

interface CityInterface extends CoreInterface{
    public function getCities($title);
}