<?php
/**
 * AliSms.php
 * @author: allen
 * @date  2020年5月12日上午11:34:56
 * @copyright  Copyright igkcms
 */
namespace common\components\dysms;

use common\components\dysms\lib\AcsClient;
use common\components\dysms\lib\SendSmsRequest;
use common\components\dysms\lib\SendBatchSmsRequest;

class AliSms extends AcsClient
{
    function __construct($accessKeyId, $accessKeySecret)
    {
        parent::__construct($accessKeyId, $accessKeySecret);
    }
    /**
     * 发送短信
     *@param:
     *@return:stdClass
     */
    public function SendSms($signName, $templateCode, $phoneNumbers, $data)
    {
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();
        
        //可选-启用https协议
        //$request->setProtocol("https");
        
        // 必填，设置短信接收号码，支持对多个手机号码发送短信，手机号码之间以英文逗号（,）分隔。上限为1000个手机号码。
        $request->setPhoneNumbers($phoneNumbers);
        
        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($signName);
        
        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($templateCode);
        
        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项array("code"=>"12345","product"=>"dsd")
        $request->setTemplateParam(json_encode($data, JSON_UNESCAPED_UNICODE));
        
        // 发起访问请求
        $acsResponse = $this->execute($request);
        
        return $acsResponse;
    }
    
    /**
     * 批量发送短信
     * @return stdClass
     */
    public static function sendBatchSms($signNames, $templateCode, $phoneNumbers, $data)
    {
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendBatchSmsRequest();
        
        //可选-启用https协议
        //$request->setProtocol("https");
        
        // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumberJson(json_encode($phoneNumbers, JSON_UNESCAPED_UNICODE));
        
        // 必填:短信签名-支持不同的号码发送不同的短信签名
        $request->setSignNameJson(json_encode($signNames, JSON_UNESCAPED_UNICODE));
        
        // 必填:短信模板-可在短信控制台中找到
        $request->setTemplateCode($templateCode);
        
        // 必填:模板中的变量替换JSON串,如模板内容为"亲爱的${name},您的验证码为${code}"时,此处的值为
        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParamJson(json_encode($data, JSON_UNESCAPED_UNICODE));
        
        // 发起访问请求
        $acsResponse = $this->execute($request);
        
        return $acsResponse;
    }
}