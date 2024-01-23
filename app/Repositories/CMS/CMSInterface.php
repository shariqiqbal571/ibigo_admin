<?php 

namespace App\Repositories\CMS;

use App\Repositories\Core\CoreInterface;

interface CMSInterface extends CoreInterface{
    public function relationCms($relation = [],$column,$value);
}