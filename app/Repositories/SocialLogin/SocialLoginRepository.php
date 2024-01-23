<?php 

namespace App\Repositories\SocialLogin;

use App\Models\SocialLogin;
use App\Repositories\Core\CoreRepository;
use Illuminate\Support\Facades\DB;

class SocialLoginRepository extends CoreRepository implements SocialLoginInterface
{
    public function __construct(SocialLogin $model)
    {
        parent::__construct($model);
    }

    public function getUser($value1,$value2)
    {
        return $this->model()
        ->whereProvider($value1)
        ->whereProviderUserId($value2)
        ->first();
    }

}
