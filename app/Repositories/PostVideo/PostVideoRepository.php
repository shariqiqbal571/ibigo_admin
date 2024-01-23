<?php 

namespace App\Repositories\PostVideo;

use App\Models\PostVideo;
use App\Repositories\Core\CoreRepository;

class PostVideoRepository extends CoreRepository implements PostVideoInterface
{
    public function __construct(PostVideo $model)
    {
        parent::__construct($model);
    }

}
