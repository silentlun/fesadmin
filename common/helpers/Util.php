<?php
/**
 * Util.php
 * @author: allen
 * @date  2020年6月4日下午2:46:49
 * @copyright  Copyright igkcms
 */
namespace common\helpers;

use Yii;
use yii\imagine\Image;
use yii\helpers\FileHelper;
use common\components\dysms\AliSms;

class Util
{
    public static function thumb($imgUrl, $width = 100, $height = 100 ,$autocut = 0, $smallpic = 'nopic.png')
    {
        $uploadUrl = Yii::$app->config->site_upload_url;
        $uploadPath = Yii::getAlias('@uploads/');
        
        if(empty($imgUrl)) return $uploadUrl.$smallpic;
        $imgUrlReplace= str_replace($uploadUrl, '', $imgUrl);
        if (strpos($imgUrlReplace, '://')) return $imgUrl;
        if (!file_exists($uploadPath.$imgUrlReplace)) return $uploadUrl.$smallpic;
        list($width_t, $height_t, $type, $attr) = getimagesize($uploadPath.$imgUrlReplace);
        if ($width >= $width_t || $height >= $height_t) return $imgUrl;
        $newimgurl = dirname($imgUrlReplace).'/thumb_'.$width.'_'.$height.'_'.basename($imgUrlReplace);
        
        if(file_exists($uploadPath.$newimgurl)) return $uploadUrl.$newimgurl;
        Image::thumbnail($uploadPath.$imgUrlReplace, $width, $height)->save($uploadPath.$newimgurl);
        return $uploadUrl.$newimgurl;
    }
    
    public static function showTemplate($pre = '')
    {
        $templateDir = Yii::getAlias('@frontend/views/content/');
        $templates = glob($templateDir.$pre.'*.php');
        if(empty($templates)) return [];
        $files = @array_map('basename', $templates);
        $templateArr = [];
        if(is_array($files)) {
            foreach($files as $file) {
                $key = substr($file, 0, -4);
                $templateArr[$key] = $file;
            }
        }
        ksort($templateArr);
        return $templateArr;
    }
    
    public static function attachmentIcon($ext = '')
    {
        $extArr = [
            'doc' => 'fa-file-word-o text-pink',
            'docx' => 'fa-file-word-o text-pink',
            'ppt' => 'fa-file-powerpoint-o text-pink',
            'pptx' => 'fa-file-powerpoint-o text-pink',
            'xls' => 'fa-file-excel-o text-pink',
            'xlsx' => 'fa-file-excel-o text-pink',
            'txt' => 'fa-file-text-o text-pink',
            'pdf' => 'fa-file-pdf-o text-pink',
            'jpg' => 'fa-file-image-o text-primary',
            'jpeg' => 'fa-file-image-o text-primary',
            'gif' => 'fa-file-image-o text-primary',
            'png' => 'fa-file-image-o text-primary',
            'bmp' => 'fa-file-image-o text-primary',
            'rar' => 'fa-file-zip-o text-brown',
            'zip' => 'fa-file-zip-o text-brown',
            '7z' => 'fa-file-zip-o text-brown',
            'gz' => 'fa-file-zip-o text-brown',
            'swf' => 'fa-file-video-o text-purple',
            'flv' => 'fa-file-video-o text-purple',
            'rm' => 'fa-file-video-o text-purple',
            'rmvb' => 'fa-file-video-o text-purple',
            'mp4' => 'fa-file-video-o text-purple',
            'mp3' => 'fa-file-audio-o text-purple',
            'wav' => 'fa-file-audio-o text-purple'
        ];
        if (array_key_exists($ext, $extArr)) {
            return $extArr[$ext];
        } else {
            return 'fa-file-o text-pink';
        }
    }
    
    public static function strCut($string, $length, $dot = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) break;
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $dot;
        }
        return $result;
    }
    
    public static function getLevel($id, $array = [], $pk= 'id', $i = 0)
    {
        foreach ($array as $n => $value){
            if ($id == $value[$pk]) {
                if ($value['parentid'] == 0) return $i;
                $i++;
                return self::getLevel($value['parentid'], $array, $pk, $i);
            }
        }
    }
    
    public static function uploadAvatar($userid, $avatardata)
    {
        if (!isset($userid) && !isset($avatardata)) return false;
        $avatardata = base64_decode($avatardata);
        $dir1 = ceil($userid / 10000);
        $dir2 = ceil($userid % 10000 / 1000);
        
        //创建图片存储文件夹
        $avatarfile = Yii::getAlias('@uploads/avatar/');
        $dir = $avatarfile.$dir1.'/'.$dir2.'/'.$userid.'/';
        if(!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
        //存储flashpost图片
        $filename = $dir.'300x300.jpg';
        file_put_contents($filename, $avatardata);
        
        $avatararr = ['300x300.jpg', '180x180.jpg', '90x90.jpg'];
        $files = glob($dir.'*');
        foreach ($files as $_files){
            if (is_dir($_files)) FileHelper::removeDirectory($_files);
            if (!in_array(basename($_files), $avatararr)) @unlink($_files);
        }
        Image::thumbnail($filename, '180', '180')->save($dir.'180x180.jpg', ['quality' => 95]);
        Image::thumbnail($filename, '90', '90')->save($dir.'90x90.jpg', ['quality' => 95]);
        return true;
    }
    
    public static function deleteAvatar($userid)
    {
        if (!isset($userid)) return false;
        $dir1 = ceil($userid / 10000);
        $dir2 = ceil($userid % 10000 / 1000);
        $avatarfile = Yii::getAlias('@uploads/avatar/');
        $dir = $avatarfile.$dir1.'/'.$dir2.'/'.$userid.'/';
        FileHelper::removeDirectory($dir);
        return true;
    }
    
    public static function randomNumber($length = 8)
    {
        $pool = '0123456789';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    
    public static function generateSN()
    {
        return date("ymdHis" ).str_pad( mt_rand( 1, 999 ), 3, "0", STR_PAD_LEFT );
    }
    
    public static function isPhone($phone)
    {
        return preg_match('/^1[0-9]{10}$/', $phone);
    }
    
    public static function isEmail($email)
    {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }
    public static function randomString($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    
    public static function randomLowerString($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    
    public static function randomUpperString($length)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    
    public static function isMobile()
    {
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
            
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
    
    public static function isWechat()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
            return false;
        } else {
            return true;
        }
    }
    
    public static function encryptStr($str = ''){
        if (!$str) return false;
        $return = '';
        if (strpos($str, '@') === false) {
            $str1 = substr($str,0,1);
            $str2 = substr($str,-1);
            $return = $str1.'*****'.$str2;
        } else {
            $email = explode('@',$str);
            $str1 = substr($email[0],0,1);
            $str2 = substr($email[0],-1);
            $return = $str1.'****'.$str2.'@'.$email[1];
        }
        return $return;
    }
    
    public static function sendSms($phoneNumbers, $data, $type = 'login')
    {
        switch ($type) {
            case 'login':
                $templateCode= 'C123456';
                break;
            case 'register':
                $templateCode= 'C123456';
                break;
            case 'changemobile':
                $templateCode= 'C123456';
                break;
            default:
                $templateCode= 'C123456';
        }
        $signName = Yii::$app->config->sms_signName;
        $accessKeyId = Yii::$app->config->sms_access_keyId;
        $accessKeySecret = Yii::$app->config->sms_access_keySecret;
        $sendsms = new AliSms($accessKeyId, $accessKeySecret);
        $response = $sendsms->SendSms($signName, $templateCode, $phoneNumbers, $data);
        if ($response->Code == 'OK') {
            return true;
        } else {
            return false;
        }
    }
    
    public static function assets($asset)
    {
        $basePath = Yii::getAlias('@webroot');
        $timestamp = @filemtime("$basePath/$asset");
        if ($timestamp) {
            return "$asset?v=$timestamp";
        } else {
            return $asset;
        }
    }
    
    /**
     * 字符串加密、解密函数
     *
     *
     * @param	string	$txt		字符串
     * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
     * @param	string	$key		密钥：数字、字母、下划线
     * @param	string	$expiry		过期时间
     * @return	string
     */
    public static function sysAuth($string, $operation = 'ENCODE', $key = 'logini7IT8vuq1udFqFN9zn9T', $expiry = 0) {
        $ckey_length = 4;
        $key = md5(md5('login'.md5('logini7IT8vuq1udFqFN9zn9T')));
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
        
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
        
        $string = $operation == 'DECODE' ? base64_decode(strtr(substr($string, $ckey_length), '-_', '+/')) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        
        $result = '';
        $box = range(0, 255);
        
        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        
        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        
        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        
        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.rtrim(strtr(base64_encode($result), '+/', '-_'), '=');
        }
    }
    
    /**
     * 内容中图片替换
     */
    public static function contentStrip($content)
    {
        $content = preg_replace_callback('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', "self::wapImg", $content);
        
        //匹配替换过的图片
        //$content = strip_tags($content,'<strong><b><br><img><p><h1><h2><h3><h4><h5><h6><div><a><embed><span><blockquote>');
        return $content;
    }
    
    /**
     * 图片过滤替换
     */
    public static function wapImg($matches) {
        return '<img src="'.$matches[1].'" style="max-width:100%;height:auto" />';
    }
    
    public static function loadThumb($thumb)
    {
        return $thumb ? $thumb : Yii::getAlias('@web/').'statics/images/nopic.jpg';
    }
    
}