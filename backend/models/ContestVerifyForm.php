<?php
/**
 * UploadForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Contest;
use common\components\event\MessageEvent;

class ContestVerifyForm extends Model
{
    const SEND_VERIFY_MESSAGE = 'verify_message';
    
    public $ids;
    public $id;
    public $status;
    public $content;
    
    public function rules()
    {
        return [
            ['status', 'required', 'message' => '请选择审核状态'],
            ['content', 'string'],
            ['content', 'required', 'when' => function($model) {
                return $model->status == Contest::STATUS_REJECT;
            }],
            ['ids' , 'string'],
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
        ];
    }
    
    public function attributeLabels(){
        return [
            'status' => '审核状态',
            'content' => '审核理由',
        ];
    }
    
    public function init ()
    {
        $this->on(self::SEND_VERIFY_MESSAGE, ['common\models\Message', 'sendMessage']);
    }
    
    public function update()
    {
        if ($this->validate()) {
            /* $ids = json_decode($this->ids);
            foreach ($ids as $id){
                $contestModel = ContestData::findOne($id);
                $contestModel->status = $this->status;
                $contestModel->save();
            } */
            if ($this->ids) {
                $ids = explode(',', $this->ids);
                foreach ($ids as $id) {
                    $contestModel = Contest::findOne($id);
                    $contestModel->status = $this->status;
                    $contestModel->save(false);
                    $event = new MessageEvent();
                    $event->from_id = Yii::$app->user->identity->id;
                    $event->to_id = $contestModel->user_id;
                    $event->title = $contestModel->title;
                    $event->status = $this->status;
                    if ($this->status == Contest::STATUS_ACTIVE) {
                        $event->content = $contestModel->type['subname'].$contestModel->id;
                    } else {
                        $event->content = $this->content;
                    }
                    $this->trigger(self::SEND_VERIFY_MESSAGE, $event);
                }
            } else {
                $contestModel = Contest::findOne($this->id);
                $contestModel->status = $this->status;
                $contestModel->save(false);
                $event = new MessageEvent();
                $event->from_id = Yii::$app->user->identity->id;
                $event->to_id = $contestModel->user_id;
                $event->title = $contestModel->title;
                $event->status = $this->status;
                if ($this->status == Contest::STATUS_ACTIVE) {
                    $event->content = $contestModel->type['subname'].$contestModel->id;
                } else {
                    $event->content = $this->content;
                }
                $this->trigger(self::SEND_VERIFY_MESSAGE, $event);
            }
            
            return true;
        } else {
            return false;
        }
    }
    
}