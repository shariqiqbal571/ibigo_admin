<?php 

namespace App\Repositories\FourSquare;

use App\Repositories\Core\CoreInterface;

interface FourSquareInterface extends CoreInterface{
    public function currentLimit($column,$value);
}