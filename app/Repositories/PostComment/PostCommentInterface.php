<?php 

namespace App\Repositories\PostComment;

use App\Repositories\Core\CoreInterface;

interface PostCommentInterface extends CoreInterface{
    public function wherePost($column1,$value1,$column2,$value2);
}