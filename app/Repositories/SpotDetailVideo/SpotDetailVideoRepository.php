<?php 

namespace App\Repositories\SpotDetailVideo;

use App\Models\SpotDetailVideo;
use App\Repositories\Core\CoreRepository;

class SpotDetailVideoRepository extends CoreRepository implements SpotDetailVideoInterface
{
    public function __construct(SpotDetailVideo $model)
    {
        parent::__construct($model);
    }

}
