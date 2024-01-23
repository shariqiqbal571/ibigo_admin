<?php 

namespace App\Repositories\Page;

use App\Models\Page;
use App\Repositories\Core\CoreRepository;

class PageRepository extends CoreRepository implements PageInterface
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

}
