<?php 

namespace App\Repositories\SocialLogin;

use App\Repositories\Core\CoreInterface;

interface SocialLoginInterface extends CoreInterface{
    public function getUser($value1,$value2);
}