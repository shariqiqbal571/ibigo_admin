<?php 

namespace App\Repositories\PostImage;

use App\Models\PostImage;
use App\Repositories\Core\CoreRepository;

class PostImageRepository extends CoreRepository implements PostImageInterface
{
    public function __construct(PostImage $model)
    {
        parent::__construct($model);
    }

}
