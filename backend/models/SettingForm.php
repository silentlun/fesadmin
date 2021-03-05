<?php
/**
 * SettingForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use yii;
use common\models\Setting;

class SettingForm extends Setting
{
    public $site_title;
    public $site_url;
    public $site_keywords;
    public $site_description;
    public $site_icp;
    public $site_statics_script;
    public $site_status;
    public $site_upload_url;
    public $site_upload_allowext;
    public $site_upload_maxsize;
    
    public function attributeLabels(){
        return [
            'site_title' => '网站标题',
            'site_url' => '网站域名',
            'site_keywords' => 'SEO关键词',
            'site_description' => 'SEO描述',
            'site_icp' => 'ICP备案号',
            'site_statics_script' => '统计代码',
            'site_status' => '站点状态',
            'site_upload_url' => '附件URL访问地址',
            'site_upload_allowext' => '允许上传文件类型',
            'site_upload_maxsize' => '允许上传附件大小',
        ];
    }
    
    public function rules(){
        return [
            [
                [
                    'site_title',
                    'site_url',
                    'site_keywords',
                    'site_description',
                    'site_icp',
                    'site_statics_script',
                    'site_upload_url',
                    'site_upload_allowext',
                    'site_upload_maxsize',
                ],
                'string'
            ],
            [ 'site_url', 'required'],
            [ 'site_url', 'validatorWebsiteUrl'],
            [['site_status'], 'integer'],
        ];
    }
    public function validatorWebsiteUrl($attribute, $params)
    {
        if( strpos($this->$attribute, "https://") === 0 || strpos($this->$attribute, "http://") === 0 || strpos($this->$attribute, "//") === 0   ){
            return;
        }
        $this->addError($attribute, yii::t("app", '{attribute} must begin with https:// or http:// or //', ['attribute'=>yii::t('app', 'Website Url')]));
        return;
    }
}