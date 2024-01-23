<?php 

namespace App\Repositories\PostLike;

use App\Repositories\Core\CoreInterface;

interface PostLikeInterface extends CoreInterface{
    public function wherePost($column1,$value1,$column2,$value2);
}