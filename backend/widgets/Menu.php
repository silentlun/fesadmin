<?php
namespace backend\widgets;

use Yii;
use backend\models\Menu as BackendMenuModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Menu extends \yii\base\Widget
{
    public $items = [];
    
    public $subTemplate = "\n<ul class='sub-menu'>\n{items}\n</ul>\n";
    
    public $dropDownCaret = '<b class="caret pull-right"></b>';
    
    public $linkIcon = '<i class="fa {icon}"></i>';
    
    public function init()
    {
        $this->items = $this->getMenus();
        
    }
    
    public function run()
    {
        return $this->renderItems();
    }
    
    public function renderItems()
    {
        $lines = '';
        $items = $this->normalizeItems();
        //print_r($items);exit;
        foreach ($items as $key => $item) {
            $lines .= Html::tag('li', $this->renderItem($item), ['class' => 'has-sub']);
        }
        return $lines;
    }
    
    public function renderItem($item)
    {
        $linkOptions = [];
        $linkIcon = strtr($this->linkIcon, [
            '{icon}' => $item['icon'],
        ]);
        $items = ArrayHelper::getValue($item, 'items');
        if (empty($items)) {
            $items = '';
            $linkRoute = $item['route'];
            $linkOptions = ['class' => 'J_menuItem'];
            $this->dropDownCaret = '';
        } else {
            $items = $this->renderDropdown($items);
            $linkRoute = 'javascript:;';
        }
        
        return Html::a($this->dropDownCaret.$linkIcon.$item['name'], $linkRoute, $linkOptions).$items;
        
    }
    
    /* 
     *  
     *  */
    protected function renderDropdown($items)
    {
        $lines = '';
        foreach ($items as $item) {
            $lines .= Html::tag('li', Html::a($item['name'], $item['route'], ['class' => 'J_menuItem']));
        }
        return strtr($this->subTemplate, ['{items}' => $lines]);
    }
    
    protected function normalizeItems($parentid = 0)
    {
        $items = [];
        foreach ($this->items as $key => $item) {
            if ($item['parentid'] != $parentid) continue;
            $array['name'] = $item['name'];
            $array['route'] = [$item['route']];
            $array['icon'] = $item['icon'];
            $subMenu = $this->normalizeItems($item['id']);
            //print_r($subMenu);
            if ($subMenu) {
                $array['items'] = $subMenu;
            }
            $items[] = $array;
            unset($this->items[$key],$array);
        }
        return $items;
    }
    

    public function getMenus()
    {
        $menus = BackendMenuModel::find()->where(['display' => BackendMenuModel::DISPLAY_YES])->orderBy("sort asc")->asArray()->all();
        $permissions = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id);
        $permissions = array_keys($permissions);

        if (!in_array(Yii::$app->user->id, Yii::$app->getBehavior('access')->superAdminUserIds)) {
            $newMenu = [];
            foreach ($menus as $_k => $menu) {
                if (in_array($menu['route'], $permissions)) {
                    $newMenu[$_k] = $menu;
                }
            }
            return $newMenu;
        }
        return $menus;
    }
}