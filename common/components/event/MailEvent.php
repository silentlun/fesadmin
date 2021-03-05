<?php
/**
 * MailEvent.php
 * @author: allen
 * @date  2020年10月14日下午3:21:47
 * @copyright  Copyright igkcms
 */
namespace common\components\event;

use yii\base\Event;

class MailEvent extends Event
{
    public $orders;
    public $users;
    public $subject;
    public $startdate;
    public $enddate;
    public $address;
    public $fromname = '活动组委会';
}