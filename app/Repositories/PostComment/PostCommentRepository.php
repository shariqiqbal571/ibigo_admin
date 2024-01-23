<?php 

namespace App\Repositories\PostComment;

use App\Models\PostComment;
use App\Repositories\Core\CoreRepository;

class PostCommentRepository extends CoreRepository implements PostCommentInterface
{
    public function __construct(PostComment $model)
    {
        parent::__construct($model);
    }

    public function wherePost($column1,$value1,$column2,$value2)
    {
        return $this->model()->where($column1,$value1)->where($column2,$value2)->get()->toArray();
    }
}
