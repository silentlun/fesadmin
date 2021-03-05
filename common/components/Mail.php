<?php
/**
 * Mail.php
 * @author: allen
 * @date  2020年10月14日下午3:03:26
 * @copyright  Copyright igkcms
 */
namespace common\components;

use Yii;

class Mail 
{
    public function sendVerifyPassMail($event)
    {
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'orderVerifyPass'],
                ['title' => $event->subject, 'startdate' => $event->startdate, 'enddate' => $event->enddate, 'address' => $event->address, 'tickets' => $event->users, 'orders' => $event->orders]
            )
            ->setFrom(['support@taibo.cn' => $event->fromname])
            ->setTo($event->orders['email'])
            ->setSubject("您申请的【{$event->subject}】已通过审核")
            ->send();
    }
    public function sendVerifyRejectMail($event)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'orderVerifyReject'],
                ['title' => $event->subject, 'startdate' => $event->startdate, 'enddate' => $event->enddate, 'address' => $event->address, 'tickets' => $event->users, 'orders' => $event->orders]
            )
            ->setFrom(['support@taibo.cn' => $event->fromname])
            ->setTo($event->orders['email'])
            ->setSubject("您的活动订单已被组委会拒绝")
            ->send();
    }
    public function sendVerifyMail($event)
    {
        Yii::$app
        ->mailer
        ->compose(
            ['html' => 'orderVerify'],
            ['title' => $event->subject, 'startdate' => $event->startdate, 'enddate' => $event->enddate, 'address' => $event->address, 'tickets' => $event->users, 'orders' => $event->orders]
            )
            ->setFrom(['support@taibo.cn' => $event->fromname])
            ->setTo($event->orders['email'])
            ->setSubject("【{$event->subject}】订单确认函")
            ->send();
    }
    public function sendPayCompleteMail($event)
    {
        $messages = [];
        foreach ($event->users as $user) {
            $messages[] = Yii::$app->mailer->compose(
                ['html' => 'orderComplete'],
                ['title' => $event->subject, 'startdate' => $event->startdate, 'enddate' => $event->enddate, 'address' => $event->address, 'ticket' => $user]
                )
                ->setFrom(['support@taibo.cn' => $event->fromname])
            ->setTo($user['email'])
            ->setSubject("【{$event->subject}】订单确认函");
        }
        Yii::$app->mailer->sendMultiple($messages);
        /* Yii::$app
        ->mailer
        ->compose(
            ['html' => 'orderComplete'],
            ['data' => $event]
            )
            ->setFrom('support@taibo.cn')
            ->setTo($event->email)
            ->setSubject("【{$event->subject}】订单确认函")
            ->send();
            Yii::$app->mailer->sendMultiple($messages); */
    }
    
}