<?php 

namespace App\Repositories\SpotImage;

use App\Models\SpotImage;
use App\Repositories\Core\CoreRepository;

class SpotImageRepository extends CoreRepository implements SpotImageInterface
{
    public function __construct(SpotImage $model)
    {
        parent::__construct($model);
    }

}
