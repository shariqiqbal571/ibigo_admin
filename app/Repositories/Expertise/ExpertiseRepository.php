<?php 

namespace App\Repositories\Expertise;

use App\Models\Expertise;
use App\Repositories\Core\CoreRepository;

class ExpertiseRepository extends CoreRepository implements ExpertiseInterface
{
    public function __construct(Expertise $model)
    {
        parent::__construct($model);
    }

    public function get($select = [],$column1,$value1)
    {
        return $this->model()
        ->select($select)
        ->where($column1,$value1)
        ->get();
    }

}
