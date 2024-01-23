<?php 

namespace App\Repositories\CMS;

use App\Models\CMS;
use App\Repositories\Core\CoreRepository;

class CMSRepository extends CoreRepository implements CMSInterface
{
    public function __construct(CMS $model)
    {
        parent::__construct($model);
    }

    public function relationCms($relation = [],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->where($column,$value)
        ->get()->toArray();
    }
}
