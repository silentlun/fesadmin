<?php
/**
 * File Description 
 *
 * @author  Allen
 * @date  2019-12-26 下午5:35:40
 * @copyright  Copyright igkcms
 */
namespace common\widgets\webuploader;

use yii\widgets\InputWidget;
use common\widgets\webuploader\assets\WebuploaderAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class Webuploader extends InputWidget
{

    public $id;

    public $module;

    private $_hashVar;

    public $config = [];

    public $value = '';

    public function init()
    {
        parent::init();
        if ($this->module == null)
            $this->module = 'event';
        empty($this->id) && $this->id = uniqid();
        $this->initConfig();
        $this->registerClientScript();
    }

    public function run()
    {
        if ($this->hasModel()) {
            $inputName = Html::getInputName($this->model, $this->attribute);
            $inputValue = Html::getAttributeValue($this->model, $this->attribute);
            return $this->render('index', [
                'inputName' => $inputName,
                'inputValue' => $inputValue,
                'hashVar' => $this->_hashVar,
                'showType' => $this->config['showType']
            ]);
        } else {
            return $this->render('index', [
                'inputName' => 'upfile',
                'inputValue' => $this->value,
                'hashVar' => $this->_hashVar,
                'showType' => $this->config['showType']
            ]);
        }
    }

    public function initConfig()
    {
        $this->_hashVar = 'webuploader_' . hash('crc32', $this->id);
        $_config = [
            'server' => Url::toRoute([
                'attachment/upload',
                'action' => 'uploadimage',
                'module' => $this->module
            ]),
            'modal_id' => $this->_hashVar,
            'showType' => 'thumb',
            'albumUrl' => Url::toRoute([
                'attachment/album',
                'modal' => $this->_hashVar
            ]),
        ];
        $this->config = ArrayHelper::merge($_config, $this->config);
        
        $config = Json::htmlEncode($this->config);
        $js = <<<JS
        var {$this->_hashVar} = {$config};
            $('#{$this->_hashVar}').webupload_fileinput({$this->_hashVar});
JS;
        $this->view->registerJs($js);
    }

    public function registerClientScript()
    {
        WebuploaderAsset::register($this->view);
    }
}