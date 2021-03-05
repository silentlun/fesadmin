<?php
/**
 * ActiveField.php
 * @author: allen
 * @date  2020年6月12日上午9:03:33
 * @copyright  Copyright igkcms
 */
namespace backend\widgets;

use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    public function init()
    {
        parent::init();
    }
    
    public function checkboxList($items, $options = [])
    {
        $options['tag'] = 'div';
        $options['class'] = 'form-checkbox';
        $itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : [];
        
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions){
            /* $checkbox = Html::checkbox($name, $checked, array_merge($itemOptions, [
                'value' => $value,
            ])); */
            $checked = $checked ? "checked" : "";
            return "<label class='checkbox checkbox-inline checkbox-primary'>
              <input type='checkbox' name='{$name}' value='{$value}' {$checked}>
              <span>{$label}</span></label>";
            
            
        };
        return parent::checkboxList($items, $options);
    }
    
    public function radioList($items, $options = [])
    {
        $options['tag'] = 'div';
        $options['class'] = 'form-radio';
        $itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : [];
        
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions){
            /* $checkbox = Html::checkbox($name, $checked, array_merge($itemOptions, [
             'value' => $value,
             ])); */
            $checked = $checked ? "checked" : "";
            return "<label class='radio radio-inline radio-primary'>
            <input type='radio' name='{$name}' value='{$value}' {$checked}>
            <span>{$label}</span></label>";
            
            
        };
        return parent::radioList($items, $options);
    }
    
    public function dateInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        if (!isset($options['class'])) {
            $options['class'] = 'kv-datetime-picker';
        }else{
            $options['class'] .= ' kv-datetime-picker';
        }
        $options['readonly'] = true;
        $inputHtml = '<div class="input-group date datetime-picker">'.Html::activeTextInput($this->model, $this->attribute, $options).'
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
        </div>';
        $this->parts['{input}'] = $inputHtml;
        
        return $this;
    }
    
    public function linkInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $options['readonly'] = true;
        
        $inputHtml = '<div class="input-group">'.Html::activeTextInput($this->model, $this->attribute, $options).'
      <label class="input-group-addon">
        <input type="checkbox"> 转向链接
      </label>
    </div>';
        $this->parts['{input}'] = $inputHtml;
        return $this;
        
    }
}