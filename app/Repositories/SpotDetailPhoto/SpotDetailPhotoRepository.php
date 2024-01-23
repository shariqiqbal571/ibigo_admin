<?php 

namespace App\Repositories\SpotDetailPhoto;

use App\Models\SpotDetailPhoto;
use App\Repositories\Core\CoreRepository;

class SpotDetailPhotoRepository extends CoreRepository implements SpotDetailPhotoInterface
{
    public function __construct(SpotDetailPhoto $model)
    {
        parent::__construct($model);
    }

}
