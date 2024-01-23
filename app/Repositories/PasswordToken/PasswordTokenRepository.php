<?php 

namespace App\Repositories\PasswordToken;

use App\Models\PasswordReset;
use App\Repositories\Core\CoreRepository;

class PasswordTokenRepository extends CoreRepository implements PasswordTokenInterface
{
    public function __construct(PasswordReset $model)
    {
        parent::__construct($model);
    }
}
