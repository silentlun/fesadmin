<?php
/**
* File Description 
*
* @author  Allen
* @date  2020-3-31 上午10:16:30
* @copyright  Copyright igkcms
*/
namespace common\components;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\Response;
use common\models\Attachment;
use yii\helpers\FileHelper;
use yii\data\Pagination;

class UploadAction extends Action{
    public $config = [];
    public $module;
    private $imageexts = ['gif', 'jpg', 'jpeg', 'png', 'bmp'];
    
    public function init(){
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        //默认设置
        $_config = require(__DIR__ . '/ueditorconfig.php');
        $this->config = ArrayHelper::merge($_config, $this->config);
        //if (Yii::$app->request->get('module')) $this->module = Yii::$app->request->get('module');
        parent::init();
        
    }
    public function run(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $action = Yii::$app->request->get('action');
        switch ($action) {
        	case 'config':
        	    //$result = json_encode($this->config);
        	    $result = $this->config;
        	    break;
        	    /* 上传图片 */
        	case 'uploadimage':
        	    /* 上传视频 */
        	case 'uploadvideo':
        	    /* 上传文件 */
        	case 'uploadfile':
        	    $result = $this->ActUpload();
        	    break;
        	    /* 列出图片 */
        	case 'listimage':
        	    $allowFiles = $this->config['imageManagerAllowFiles'];
        	    $type = 1;
        	    $result = $this->ActList($type);
        	    break;
        	    /* 列出文件 */
        	case 'listfile':
        	    $allowFiles = $this->config['fileManagerAllowFiles'];
        	    $type = 0;
        	    $result = $this->ActList($type);
        	    break;
        	    /* 抓取远程文件 */
        	case 'catchimage':
        	    $result = $this->ActCrawler();
        	    break;
        	default:
        	    $result = $this->ActUpload();
        	    break;
        }
        /* 输出结果 */
        return $result;
        /* if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                        'state' => 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        } */
    }
    
    public function ActList($type)
    {
        $start = Yii::$app->request->get('start', 0);
        $query = Attachment::find()->where(['isimage' => $type]);
        $count = $query->count();
        if (!$count) {
            return [
                'state' => 'no match file',
                'list' => [],
                'start' => $start,
                'total' => 0
            ];
        }
        $pagination = new Pagination(['totalCount' => $count, 'pageParam' => 'start']);
        $attachments = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->asArray()->all();
        if ($attachments) {
            foreach ($attachments as $r){
                $files[] = [
                    'url' => Yii::$app->config->site_upload_url.$r['filepath'],
                    'mtime' => $r['created_at'],
                ];
            }
        }
        return [
            'state' => 'SUCCESS',
            'list' => $files,
            'start' => intval($start),
            'total' => $pagination->pageCount
        ];
    }
    
    public function ActList1($allowFiles)
    {
        $size = Yii::$app->request->get('size', 20);
        $start = Yii::$app->request->get('start', 0);
        $end = $start + $size;
        
        $allowFiles = substr(str_replace('.', '|', implode('', $allowFiles)), 1);
        $basePath = Yii::getAlias('@uploads/');//项目根目录
        $files = $fileArr = [];
        $files = FileHelper::findFiles($basePath);
        
        foreach ($files as $file) {
            if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                //$url = 
                $fileArr[] = [
                    'url' => Yii::$app->config->site_upload_url.str_replace('\\', '/', substr(str_replace($basePath, '', $file), 1)),
                    'mtime' => filemtime($file)
                ];
            }
        }
        
        /* 获取指定范围的列表 */
        $len = count($fileArr);
        for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--){
            $list[] = $fileArr[$i];
        }
        
        return [
            'state' => 'SUCCESS',
            'list' => $list,
            'start' => $start,
            'total' => count($fileArr)
        ];
    }
    
    public function ActUpload(){
        /* exit(json_encode(array(
                "state" => 'SUCCESS',
                "url" => '234',
                "title" => '23423',
                "original" => '2342343',
                "type" => '1',
                "size" => '1'
        ))); */
        
        
        $upload = UploadedFile::getInstanceByName("upload");
        if ($upload != null){
            $original_name = $upload->getBaseName();//原文件名
            $ext = $upload->getExtension();//扩展名
            //判断文件类型'png', 'jpg', 'jpeg', 'gif', 'mp3', 'mp4', 'm3u8'
            if( !in_array(strtolower($upload->getExtension()), explode('|', Yii::$app->config->site_upload_allowext)) ){
                return [
                "state" => '格式不允许',
                ];
            }
            //判断文件大小
            if ($upload->size > Yii::$app->config->site_upload_maxsize*1024){
                return [
                "state" => '文件大小超出限制',
                ];
            }
            $filename = date('YmdHis').mt_rand(100, 999).'.'.$ext;
            $basePath = Yii::getAlias('@uploads/');//项目根目录
            
            $savepath = $basePath.date('Y/md/');
            if (!file_exists($savepath)) {
                FileHelper::createDirectory($savepath);
            }
            $savefile = $savepath.$filename;
            $filepath = str_replace($basePath, '', $savefile);
            if($upload->saveAs($savefile)) {
                $aid = $this->add(['filename'=>$original_name.'.'.$ext,'filepath'=>$filepath,'filesize'=>$upload->size,'fileext'=>$ext]);
                //
                $this->uploadJson($aid, Yii::$app->config->site_upload_url.$filepath);
                return [
                    'state'=>'SUCCESS', 
                    'url' => Yii::$app->config->site_upload_url.$filepath,
                    'title'=>$filename
                ];
            } else {
                return ['state'=>'上传失败'];
            }
        }
    }

    /**
     * 附件添加如数据库
     * @param $uploadedfile 附件信息
     */
    public function add($uploadedfile) {
        $model = new Attachment();
        $model->module = isset($this->module) && $this->module ? $this->module : 'content';
        $model->filename = $uploadedfile['filename'];
        $model->filepath = $uploadedfile['filepath'];
        $model->filesize = $uploadedfile['filesize'];
        $model->fileext = $uploadedfile['fileext'];
        $model->isimage = in_array($uploadedfile['fileext'], $this->imageexts) ? 1 : 0;
        $model->status = 0;
        $model->save();
        $aid = $model->attributes['id'];
        return $aid;
        
    }

    /**
     * 设置上传的json格式cookie
     */
    public function uploadJson($aid, $filepath) {
    	$arr['aid'] = intval($aid);
    	$arr['src'] = $filepath;
    	//$arr['filename'] = $filename;
    	$json_str = json_encode($arr);
    	$att_arr_exist = Yii::$app->request->cookies->getValue('att_json','');
    	$att_arr_exist_tmp = explode('||', $att_arr_exist);
    	if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
    		return true;
    	} else {
    		$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
    		//param::set_cookie('att_json',$json_str);
    		$cookies = Yii::$app->response->cookies;
    		$cookies->add(new \yii\web\Cookie([
    				'name' => 'att_json',
    				'value' => $json_str,
    				]));
    		/* $cookies->add(new \yii\web\Cookie([
    				'att_json' => '2121',
    				])); */
    		return true;
    	}
    	
    
    }
    

    /**
     * 最终显示结果，自动输出 JSONP 或者 JSON
     *
     * @param array $result
     * @return array
     */
    protected function _show_msg($result)
    {
        $callback = Yii::$app->request->get('callback', null);
    
        if ($callback && is_string($callback)) {
            Yii::$app->response->format = Response::FORMAT_JSONP;
            return [
            'callback' => $callback,
            'data' => $result
            ];
        }
    
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}