<?php
/**
 * 创建微信支付操作类
 * @author: allen
 * @date  2020年4月29日下午2:44:54
 * @copyright  Copyright igkcms
 */
namespace common\components\payment\wxpay;

use Yii;
use yii\base\Exception;
use common\components\payment\wxpay\lib\WxPayApi;
use common\components\payment\wxpay\lib\WxPayJsApiPay;
use common\components\payment\wxpay\lib\WxPayUnifiedOrder;
use common\components\payment\wxpay\lib\WxPayNotify;
use common\components\payment\wxpay\lib\WxPayOrderQuery;

class WxPay extends WxPayApi
{
    public $config = [
        'appid' => '',
        'mch_id' => '',
        'key' => '',
        'app_secret' => '',
        'sign_type' => 'MD5',
        'report_levenl' => '1'
    ];
    
    public function  __construct(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }
    
    /**
     * 创建jsapi,小程序支付
     *@param:订单数组
     *@return:
     */
    public function createMiniPay($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['title']);
        $input->SetOut_trade_no($order['trade_sn']);
        $input->SetTotal_fee($order['total_fee'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($order['notify_url']);
        $input->SetOpenid($order['openid']);
        $input->SetTrade_type("JSAPI");
        
        $result = self::unifiedOrder($this->config, $input);
        return $result;
    }
    
    /**
     * 创建APP支付
     *@param:
     *@return:
     */
    public function createAppPay($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['title']);
        $input->SetOut_trade_no($order['trade_sn']);
        $input->SetTotal_fee($order['total_fee'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($order['notify_url']);
        $input->SetTrade_type("APP");
        
        $result = self::unifiedOrder($this->config, $input);
        return $result;
    }
    
    /**
     * 创建H5支付
     *@param:
     *@return:
     */
    public function createWebPay($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['title']);
        $input->SetOut_trade_no($order['trade_sn']);
        $input->SetTotal_fee($order['total_fee'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($order['notify_url']);
        $input->SetTrade_type("MWEB");
        $input->SetScene_info($order['scene_info']);
        
        $result = self::unifiedOrder($this->config, $input);
        return $result;
    }
    
    /**
     * 创建扫码支付
     *@param:
     *@return:
     */
    public function createNativePay($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['title']);
        $input->SetOut_trade_no($order['trade_sn']);
        $input->SetTotal_fee($order['total_fee'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($order['notify_url']);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order['product_id']);
        
        $result = self::unifiedOrder($this->config, $input);
        return $result["code_url"];
    }
    
    /**
     *
     * 回调入口
     * @param array $result 
     */
    final public function Handle($result)
    {
        $notify = new WxPayNotify();
        //当返回false的时候，表示notify回调失败获取签名校验失败，此时直接回复失败
        if($result == false){
            $notify->SetReturn_code("FAIL");
            $notify->SetReturn_msg($msg);
        } else {
            //该分支在成功回调处理完成之后流程
            $notify->SetReturn_code("SUCCESS");
            $notify->SetReturn_msg("OK");
        }
        $xml = $notify->ToXml();
        self::replyNotify($xml);
        //$this->ReplyNotify($notify,$needSign);
    }
    
    /**
     * 查询支付订单
     *@param:
     *@return:
     */
    public function QueryOrder()
    {
        $msg = "OK";
        $result = self::notify($this->config, $msg);
        if (!$result) return false;
        if(!array_key_exists("return_code", $result) || (array_key_exists("return_code", $result) && $result['return_code'] != "SUCCESS")) {
            //失败,不是支付成功的通知
            return false;
        }
        if(!array_key_exists("transaction_id", $result)){
            //失败，缺少参数
            return false;
        }
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($result["transaction_id"]);
        $queryResult = self::orderQuery($this->config, $input);
        if(array_key_exists("return_code", $queryResult) && array_key_exists("result_code", $queryResult)
            && $queryResult["return_code"] == "SUCCESS"
            && $queryResult["result_code"] == "SUCCESS")
        {
            return $result;
        }
        return false;
    }
    
    /**
     *
     * 网页授权接口微信服务器返回的数据，返回样例如下
     * {
     *  "access_token":"ACCESS_TOKEN",
     *  "expires_in":7200,
     *  "refresh_token":"REFRESH_TOKEN",
     *  "openid":"OPENID",
     *  "scope":"SCOPE",
     *  "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
     * }
     * 其中access_token可用于获取共享收货地址
     * openid是微信支付jsapi支付接口必须的参数
     * @var array
     */
    public $data = null;
    
    /**
     *
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     *
     * @return 用户的openid
     */
    public function GetOpenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
            $url = $this->_CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->GetOpenidFromMp($code);
            return $openid;
        }
    }
    
    /**
     *
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @throws WxPayException
     *
     * @return json数据，可直接填入js函数作为参数
     */
    public function GetJsApiParameters($UnifiedOrderResult)
    {
        if(!array_key_exists("appid", $UnifiedOrderResult)
            || !array_key_exists("prepay_id", $UnifiedOrderResult)
            || $UnifiedOrderResult['prepay_id'] == "")
        {
            throw new Exception("参数错误");
        }
        
        $jsapi = new WxPayJsApiPay();
        $jsapi->SetAppid($UnifiedOrderResult["appid"]);
        $timeStamp = time();
        $jsapi->SetTimeStamp("$timeStamp");
        $jsapi->SetNonceStr(self::getNonceStr());
        $jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
        
        
        $jsapi->SetPaySign($jsapi->MakeSign($this->config));
        //$parameters = json_encode($jsapi->GetValues());
        $parameters = $jsapi->GetValues();
        return $parameters;
    }
    
    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        
        //初始化curl
        $ch = curl_init();
        $curlVersion = curl_version();
        
        $ua = "WXPaySDK/3.0.9 (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version']." "
            .$this->config['mch_id'];
            
            //设置超时
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            
            $proxyHost = "0.0.0.0";
            $proxyPort = 0;
            //$config->GetProxy($proxyHost, $proxyPort);
            if($proxyHost != "0.0.0.0" && $proxyPort != 0){
                curl_setopt($ch,CURLOPT_PROXY, $proxyHost);
                curl_setopt($ch,CURLOPT_PROXYPORT, $proxyPort);
            }
            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //取出openid
            $data = json_decode($res,true);
            $this->data = $data;
            return $data['openid'];
    }
    
    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    
    /**
     *
     * 获取地址js参数
     *
     * @return 获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
     */
    public function GetEditAddressParameters()
    {
        
        $getData = $this->data;
        $data = array();
        $data["appid"] = $this->config['appid'];
        $data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $time = time();
        $data["timestamp"] = "$time";
        $data["noncestr"] = self::getNonceStr();
        $data["accesstoken"] = $getData["access_token"];
        ksort($data);
        $params = $this->ToUrlParams($data);
        $addrSign = sha1($params);
        
        $afterData = array(
            "addrSign" => $addrSign,
            "signType" => "sha1",
            "scope" => "jsapi_address",
            "appId" => $this->config['appid'],
            "timeStamp" => $data["timestamp"],
            "nonceStr" => $data["noncestr"]
        );
        $parameters = json_encode($afterData);
        return $parameters;
    }
    
    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return 返回构造好的url
     */
    private function _CreateOauthUrlForCode($redirectUrl)
    {
        
        $urlObj["appid"] = $this->config['appid'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }
    
    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        
        $urlObj["appid"] = $this->config['appid'];
        $urlObj["secret"] = $this->config['app_secret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }
}