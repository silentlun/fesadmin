<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-15 09:25
 */

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Bar extends Widget
{
    public $buttons = [];

    public $options = [
        'class' => 'mail-tools tooltip-demo',
    ];
    public $template = "{create} {listorder} {delete}";
    
    public $catid = null;
    public $module = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $request = Yii::$app->request;
        $this->catid = $request->get('catid');
        if (!$this->module) $this->module = $request->get('module');
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $buttons = '';
        $this->initDefaultButtons();
        $buttons .= $this->renderDataCellContent();
        return "<div class='{$this->options['class']}'>{$buttons}</div>";
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                return $this->buttons[$name] instanceof \Closure ? call_user_func($this->buttons[$name]) : $this->buttons[$name];
            } else {
                return '';
            }


        }, $this->template);
    }

    /**
     * 生成默认按钮
     *
     */
    protected function initDefaultButtons()
    {
        if (! isset($this->buttons['listorder'])) {
            $this->buttons['listorder'] = function () {
                return Html::a('<i class="fa fa-refresh"></i> ' . Yii::t('app', 'Listorder'), Url::to(['sort']), [
                    'title' => Yii::t('app', 'Refresh'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-warning m-r-5 listorder',
                ]);
            };
        }

        if (! isset($this->buttons['create'])) {
            $this->buttons['create'] = function () {
                return Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), Url::to(['create', 'catid' => $this->catid, 'module' => $this->module]), [
                    'title' => Yii::t('app', 'Create'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-primary m-r-5',
                ]);
            };
        }

        if (! isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function () {
                return Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('app', 'Delete'), Url::to(['delete']), [
                    'title' => Yii::t('app', 'Delete'),
                    'data-pjax' => '1',
                    'data-confirm' => Yii::t('app', 'Really to delete?'),
                    'class' => 'btn btn-danger m-r-5 multi-operate',
                ]);
            };
        }
        
        if (! isset($this->buttons['address'])) {
            $this->buttons['address'] = function () {
                return Html::a('<i class="fa fa-random"></i> ' . Yii::t('app', 'Attachment address'), Url::to(['address']), [
                    'title' => Yii::t('app', 'Attachment address'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-info m-r-5',
                ]);
            };
        }
        
        if (! isset($this->buttons['thumb-delete'])) {
            $this->buttons['thumb-delete'] = function () {
                return Html::a('<i class="fa fa-inbox"></i> ' . Yii::t('app', 'Delete Thumbnail'), Url::to(['attachment/thumbdeleteall']), [
                    'title' => Yii::t('app', 'Delete Thumbnail'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-warning m-r-5 thumb-delete',
                ]);
            };
        }
        
        if (! isset($this->buttons['verify'])) {
            $this->buttons['verify'] = function () {
                return Html::a('<i class="fa fa-check-square-o"></i> ' . Yii::t('app', 'Verify'), Url::to(['verify']), [
                    'title' => Yii::t('app', 'Verify'),
                    
                    'class' => 'btn btn-warning m-r-5 multi-verify',
                ]);
            };
        }
    }
}