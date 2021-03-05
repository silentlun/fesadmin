<?php
/**
 * MessageEvent.php
 * @author: allen
 * @date  2020年12月28日上午10:33:55
 * @copyright  Copyright igkcms
 */
namespace common\components\event;


use yii\base\Event;

class MessageEvent extends Event
{
    public $from_id;
    public $to_id;
    public $title;
    public $content;
    public $status;
}