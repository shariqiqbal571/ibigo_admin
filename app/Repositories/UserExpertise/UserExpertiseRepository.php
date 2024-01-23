<?php 

namespace App\Repositories\UserExpertise;

use App\Models\UserExpertise;
use App\Repositories\Core\CoreRepository;

class UserExpertiseRepository extends CoreRepository implements UserExpertiseInterface
{
    public function __construct(UserExpertise $model)
    {
        parent::__construct($model);
    }

}
