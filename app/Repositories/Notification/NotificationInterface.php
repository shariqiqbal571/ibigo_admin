<?php 

namespace App\Repositories\Notification;

use App\Repositories\Core\CoreInterface;

interface NotificationInterface extends CoreInterface{
    public function getNotification($relation=[],$column,$value);
    public function requestNoti($column1, $value1,$column2, $value2,$column3,$value3);
    public function deleteOldNoti($column1, $value1,$column2, $value2,$column3,$value3,$column4,$value4);
    public function twoWhere($column1,$value1,$column2,$value2);
    public function updateNotification($column1,$value1,$column2,$value2,$params = []);
    public function getNotificationGroup($column1,$value1,$column2,$value2,$column3,$value3,$column4,$value4);
}