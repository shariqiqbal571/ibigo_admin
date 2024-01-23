<?php 

namespace App\Repositories\PostStatus;

use App\Repositories\Core\CoreInterface;

interface PostStatusInterface extends CoreInterface{
    public function getPostStatus($column,$value= [],$id);
}