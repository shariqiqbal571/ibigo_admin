<?php 

namespace App\Repositories\PostAudio;

use App\Models\PostAudio;
use App\Repositories\Core\CoreRepository;

class PostAudioRepository extends CoreRepository implements PostAudioInterface
{
    public function __construct(PostAudio $model)
    {
        parent::__construct($model);
    }

}
