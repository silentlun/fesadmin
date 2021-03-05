<?php
/**
 * ActionColumn.php
 * @author: allen
 * @date  2020年6月11日下午3:07:38
 * @copyright  Copyright igkcms
 */
namespace backend\components\grid;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $header = 'Operation';
    
    public $width = '150';
    
    public $template = '{update} {delete}';
    
    public function init()
    {
        parent::init();
        $this->header = Yii::t('app', $this->header);
        if (!isset($this->headerOptions['width'])) {
            $this->headerOptions['width'] = $this->width;
        }
        $this->headerOptions['class'] = 'text-center';
        $this->contentOptions = ['class' => 'text-right'];
    }
    
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view-layer'])) {
            $this->buttons['view-layer'] = function ($url, $model, $key) {
                return Html::a('<i class="fa fa-eye"></i> '.Yii::t('app', 'View'), $url, [
                    'class' => 'btn btn-info btn-xs',
                    'title' => Yii::t('app', 'View'),
                    //'onclick' => "viewLayer('" . $url . "',$(this))",
                    'data-toggle' => 'modal',
                    'data-target' => '#ajaxModal',
                    'data-pjax' => '0'
                ]);
            };
        }
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<i class="fa fa-folder"></i> '.Yii::t('app', 'View'), $url, [
                    'class' => 'btn btn-info btn-xs',
                    'title' => Yii::t('app', 'View'),
                    'data-pjax' => '0'
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<i class="fa fa-edit"></i> '.Yii::t('app', 'Edit'), $url, [
                    'class' => 'btn btn-success btn-xs',
                    'title' => Yii::t('app', 'Edit'),
                    'data-pjax' => '0'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $data = ['id' => $key];
                return Html::a('<i class="fa fa-ban"></i> '.Yii::t('app', 'Delete'), $url, [
                    'class' => 'btn btn-danger btn-xs',
                    'title' => Yii::t('app', 'Delete'),
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this data?'),
                        'method' => 'post',
                        'params' => json_encode($data),
                    ]
                ]);
            };
        }
    }
}