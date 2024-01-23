<?php 

namespace App\Repositories\FourSquare;

use App\Models\FourSquare;
use App\Repositories\Core\CoreRepository;

class FourSquareRepository extends CoreRepository implements FourSquareInterface
{
    public function __construct(FourSquare $model)
    {
        parent::__construct($model);
    }

    public function currentLimit($column,$value)
    {
        return $this->model()
        ->orderBy($column,$value)
        ->limit(1)
        ->get()->toArray();
    }

}
