<?php 

namespace App\Repositories\City;

use App\Models\City;
use App\Repositories\Core\CoreRepository;

class CityRepository extends CoreRepository implements CityInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function getCities($title)
    {
        return $this->model()
        ->select($title)
        ->get();
    }
}
