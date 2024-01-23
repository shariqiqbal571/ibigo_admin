<?php 

namespace App\Repositories\GroupChat;

use App\Models\GroupChat;
use App\Repositories\Core\CoreRepository;

class GroupChatRepository extends CoreRepository implements GroupChatInterface
{
    public function __construct(GroupChat $model)
    {
        parent::__construct($model);
    }

}
