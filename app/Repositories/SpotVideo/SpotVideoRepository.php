<?php 

namespace App\Repositories\SpotVideo;

use App\Models\SpotVideo;
use App\Repositories\Core\CoreRepository;

class SpotVideoRepository extends CoreRepository implements SpotVideoInterface
{
    public function __construct(SpotVideo $model)
    {
        parent::__construct($model);
    }

}
