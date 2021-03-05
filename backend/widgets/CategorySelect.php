<?php
/**
 * CategorySelect.php
 * @author: allen
 * @date  2020年4月23日下午2:20:42
 * @copyright  Copyright igkcms
 */
namespace backend\widgets;


use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;

class CategorySelect extends InputWidget
{
    public $defaultRoute = 'category/treeview';
    public $categorys = [];
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        $inputName = Html::getInputName($this->model, $this->attribute);
        $inputValue = Html::getAttributeValue($this->model, $this->attribute);
        $catname = $inputValue ? $this->categorys[$inputValue]['catname'] : '';
        $tagstr = "<div class=\"input-group\">
        <input type=\"text\" class=\"form-control\" id=\"catname\" value=\"{$catname}\" placeholder=\"选择栏目\" required disabled>
    <span class=\"input-group-btn\">
    <a class=\"btn btn-success\" href=\"".Url::toRoute($this->defaultRoute)."\" data-toggle=\"modal\" data-target=\"#ajaxModal\" id=\"selectcategory1\"><i class=\"fa fa-send\"></i> 切换</a>
    </span>
  </div><input type=\"hidden\" name=\"{$inputName}\" id=\"catid\" value=\"{$inputValue}\">";
        $url = Url::toRoute($this->defaultRoute);
        $js = <<<JS
$("#selectcategory").on('click',function(e){
    layer.open({
      title: '选择栏目',
      type: 2,
      area: ['400px', '450px'],
      btn: ['确定', '取消'],
      content: '{$url}',
        yes: function(index, layero){
            var data=$(layero).find("iframe")[0].contentWindow.callbackdata();
$('#catname').val(data.catname);
$('#catid').val(data.catid);
layer.close(index);
          }
    });
});

JS;
        $this->view->registerJs($js);
        return $tagstr;
        
    }
}