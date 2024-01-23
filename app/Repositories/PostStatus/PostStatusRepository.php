<?php 

namespace App\Repositories\PostStatus;

use App\Models\PostStatus;
use App\Repositories\Core\CoreRepository;

class PostStatusRepository extends CoreRepository implements PostStatusInterface
{
    public function __construct(PostStatus $model)
    {
        parent::__construct($model);
    }

    public function getPostStatus($column,$value= [],$id)
    {
        return $this->model()
        ->whereIn($column,$value)
        ->where(function ($query) use ($id)
        {
            $query->where('status',0)
            ->orWhere('status',1)
            ->orWhere(function ($query1) use ($id){
                $query1->where('status',2)->where('user_id',$id);
            });
        })
        ->get()->toArray();
    }
}
