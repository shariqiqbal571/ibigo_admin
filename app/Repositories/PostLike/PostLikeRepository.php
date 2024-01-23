<?php 

namespace App\Repositories\PostLike;

use App\Models\PostLike;
use App\Repositories\Core\CoreRepository;

class PostLikeRepository extends CoreRepository implements PostLikeInterface
{
    public function __construct(PostLike $model)
    {
        parent::__construct($model);
    }

    public function wherePost($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }
}
