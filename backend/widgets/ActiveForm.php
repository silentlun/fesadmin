<?php
/**
 * ActiveForm.php
 * @author: allen
 * @date  2020年6月11日下午5:41:27
 * @copyright  Copyright igkcms
 */
namespace backend\widgets;

use Yii;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'backend\widgets\ActiveField';
    public $options = [
        'class' => 'form-horizontal',
        'id' => 'myform'
    ];
    public $fieldConfig = [
        'template' => "{label}\n<div class=\"col-sm-8\">{input}{hint}{error}</div>",
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ];
    
    
    /**
     * 生成表单确认和重置按钮
     *
     * @param array $options
     * @return string
     */
    
    public function defaultButtons(array $options = [])
    {
        $options['size'] = isset($options['size']) ? $options['size'] : 2;
        return '<div class="form-group">
                    <div class="col-sm-' . $options['size'] . ' col-sm-offset-2">
                        <button class="btn btn-primary btn-block" type="submit">' . Yii::t('app', 'Save') . '</button>
                    </div>
                </div>';
    }
}