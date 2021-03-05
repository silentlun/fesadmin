<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\PositionData;
use common\helpers\Util;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property int $id
 * @property int $catid
 * @property string $title
 * @property string $subtitle
 * @property string $thumb
 * @property string $keywords
 * @property string|null $description
 * @property string|null $content
 * @property string $username
 * @property string $copyfrom
 * @property string $template
 * @property string $url
 * @property int $posids
 * @property int $status
 * @property int $islink
 * @property int $created_at
 * @property int $updated_at
 */
class Content extends \yii\db\ActiveRecord
{
    public $linkurl;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%content}}';
    }
    /**
     * {@inheritdoc}
     */
/*     public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    } */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catid', 'status', 'islink'], 'integer'],
            [['title', 'catid'], 'required'],
            [['title', 'subtitle'], 'trim'],
            [['description', 'content'], 'string'],
            [['title', 'subtitle', 'thumb', 'keywords', 'copyfrom', 'template', 'url'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 99],
            [['created_at', 'updated_at', 'linkurl', 'posid'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'catid' => Yii::t('app', 'Catid'),
            'title' => Yii::t('app', 'Title'),
            'subtitle' => Yii::t('app', 'Subtitle'),
            'thumb' => Yii::t('app', 'Thumb'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'username' => Yii::t('app', 'Username'),
            'copyfrom' => Yii::t('app', 'Copyfrom'),
            'template' => Yii::t('app', 'Template'),
            'url' => Yii::t('app', 'Url'),
            'posid' => Yii::t('app', 'Posids'),
            'status' => Yii::t('app', 'Status'),
            'islink' => Yii::t('app', 'Islink'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'catid']);
    }
    public function beforeSave($insert){
    	
    	if (parent::beforeSave($insert)){
    	    if ($this->isNewRecord){
    	        $this->username = Yii::$app->user->identity->username;
    	        $this->created_at = strtotime($this->created_at);
    	        $this->updated_at = time();
    	    }else{
    	        $this->created_at = strtotime($this->created_at);
    	        $this->updated_at = time();
    	    }
            //$posids = Yii::$app->request->post('posids',[]);
            //$this->posids = count($posids)==0 ? 0 : 1;
            $this->posid = is_array($this->posid) ? implode(',', $this->posid) : '';
            //自动提取摘要
            if (isset($_POST['add_introduce']) && $this->description == '' && isset($this->content)) {
                $content = stripslashes($this->content);
                $introcude_length = intval($_POST['introcude_length']);
                $this->description = Util::strCut(str_replace(array("'","\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($content)),$introcude_length, '');
            }
            
            //自动提取缩略图
            if(isset($_POST['auto_thumb']) && $this->thumb == '' && isset($this->content)) {
                $content = stripslashes($this->content);
                $auto_thumb_no = intval($_POST['auto_thumb_no'])-1;
                if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
                    $this->thumb = $matches[3][$auto_thumb_no];
                }
            }
            return true;
        }else{
            return false;
        }
    }
    public function afterSave($insert, $changedAttributes){
    	Attachment::apiUpdate('c-'.$this->id);
    	if ($this->islink) {
    	    $this->url = $this->linkurl;
    	} else {
    	    $this->url = '/detail/'.$this->id;
    	}
    	self::updateAll(['url' => $this->url], ['id' => $this->id]);
    	//$posids = Yii::$app->request->post('posids',[]);
    	$posids = $this->posid ? explode(',', $this->posid) : [];
    	$textcontent = [];
    	$textcontent['title'] = $this->title;
    	if($this->thumb){
    		$textcontent['thumb'] = $this->thumb;
    	}
    	$textcontent['url'] = $this->url;
    	$textcontent['description'] = $this->description;
    	$textcontent['created_at'] = $this->created_at;
    	$textcontent = \yii\helpers\Json::encode($textcontent);
    	$thumb = $this->thumb ? 1 : 0;
    	if ($this->isNewRecord){
    		if (!empty($posids) && is_array($posids)){
    			foreach ($posids as $posid){
    				$posdata = new PositionData();
    				$posdata->content_id = $this->id;
    				$posdata->catid = $this->catid;
    				$posdata->posid = $posid;
    				$posdata->thumb = $thumb;
    				$posdata->data = $textcontent;
    				$posdata->created_at = $this->created_at;
    				$posdata->sort = $this->id;
    				$posdata->save();
    			}
    		}
    		
    		 
    	}else{
    	    $result = PositionData::getPositionData($this->catid, $this->id);
    		if($result){
    			foreach ($result as $v) $array[] = $v['posid'];
    			//差集计算，需要删除的推荐
    			$real_posid = implode(',', array_diff($array,$posids));
    			if ($real_posid) {
    			    $sql = "`catid`='$this->catid' AND `content_id`='$this->id' AND `posid` IN ($real_posid)";
    			    PositionData::deleteAll($sql);
    			}
    		}
    		if (!empty($posids) && is_array($posids)){
    			foreach ($posids as $posid){
    				if ($pos_data = PositionData::findOne(['content_id'=>$this->id, 'catid'=>$this->catid, 'posid'=>$posid])) {
    				    $pos_data->content_id = $this->id;
    					$pos_data->catid = $this->catid;
    					$pos_data->posid = $posid;
    					$pos_data->thumb = $thumb;
    					$pos_data->data = $textcontent;
    					$pos_data->created_at = $this->created_at;
    					$pos_data->sort = $this->id;
    					$pos_data->save();
    						
    				} else {
    					$posdata = new PositionData();
    					$posdata->content_id = $this->id;
    					$posdata->catid = $this->catid;
    					$posdata->posid = $posid;
    					$posdata->module = 'content';
    					$posdata->thumb = $thumb;
    					$posdata->data = $textcontent;
    					$posdata->created_at = $this->created_at;
    					$posdata->sort = $this->id;
    					$posdata->save();
    				}
    			}
    		}
    	}
    	
    	parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        Attachment::apiDelete('c-'.$this->id);
        PositionData::deleteAll(['content_id'=>$this->id, 'module'=>'content']);
    }
}
