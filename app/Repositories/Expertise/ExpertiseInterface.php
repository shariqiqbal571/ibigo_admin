<?php 

namespace App\Repositories\Expertise;

use App\Repositories\Core\CoreInterface;

interface ExpertiseInterface extends CoreInterface{
    public function get($select = [],$column1,$value1);
}