<?php
/**
 * CategoryTree.php
 * @author: silentlun
 * @date  2021年3月29日下午3:15:53
 * @copyright  Copyright igkcms
 */
namespace backend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class CategoryTree extends Widget
{
    public $data = [];
    
    public $route = 'content/index';
    
    public function run()
    {
        parent::run();
        if (!$this->data) return Yii::t('app', 'please_add_category');
        
        return $this->getChild(0);
    }
    
    public function getChild($myid){
        $sublist = '';
        foreach ($this->data as $id => $v){
            if ($v['parentid'] != $myid) continue;
            $child = $this->getChild($id);
            if ($child) {
                $label = Html::tag('span', $v['catname'], ['class' => 'folder']) . $child;
            } else {
                $route = $v['type'] == 1 ? 'page/index' : $this->route;
                $item = Html::a($v['catname'], [$route, 'catid' => $v['id']], ['class' => 'filetree-item', 'data-pjax' => 1]);
                $labelClass = $v['type'] == 1 ? 'file' : 'add';
                $label = Html::tag('span', $item, ['class' => $labelClass]);
            }
            $sublist .= Html::tag('li', $label, ['id' => $v['id']]);
        }
        if (!$sublist) return false;
        if ($myid == 0) {
            return Html::tag('ul', $sublist, ['class' => 'filetree treeview', 'id' => 'category_tree']);
        }
        return Html::tag('ul', $sublist);
        
    }
}