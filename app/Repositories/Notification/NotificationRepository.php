<?php 

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\Core\CoreRepository;

class NotificationRepository extends CoreRepository implements NotificationInterface
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function getNotification($relation=[],$column,$value)
    {
        return $this->model()
        ->with($relation)
        ->where($column,$value)
        ->orderBy('notification_time','desc')
        ->get()->toArray();
    }

    public function twoWhere($column1,$value1,$column2,$value2)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->get();
    }

    public function updateNotification($column1,$value1,$column2,$value2,$params = [])
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->update($params);
    }
    
    public function requestNoti($column1, $value1,$column2, $value2,$column3,$value3)
    {
        return $this->model()->where($column1,$value1)
        ->where($column2,$value2)
        ->where($column3,$value3)
        ->get()->toArray();
    }

    public function deleteOldNoti($column1, $value1,$column2, $value2,$column3,$value3,$column4,$value4)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->where($column3,$value3)
        ->where($column4,$value4)
        ->delete();
    }

    public function getNotificationGroup($column1,$value1,$column2,$value2,$column3,$value3,$column4,$value4)
    {
        return $this->model()
        ->where($column1,$value1)
        ->where($column2,$value2)
        ->where($column3,$value3)
        ->where($column4,$value4)
        ->get()->toArray();
    }
}
