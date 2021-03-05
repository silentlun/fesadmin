<?php
/**
 * AcsClient.php
 * @author: allen
 * @date  2020年5月11日下午4:25:45
 * @copyright  Copyright igkcms
 */
namespace common\components\dysms\lib;

use yii\base\Exception;
class AcsClient
{    
    protected $protocol = 'https';
    protected $domain = 'dysmsapi.aliyuncs.com';
    protected $format = 'json';
    protected $signatureMethod = 'HMAC-SHA1';
    protected $signatureVersion = '1.0';
    protected $version = '2017-05-25';
    protected $product = 'Dysmsapi';
    protected $regionId = 'cn-hangzhou';
    protected $httpMethod = 'POST';
    protected $accessKeyId;
    protected $accessKeySecret;
    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';
    
    function  __construct($accessKeyId, $accessKeySecret)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
    }
    public function execute($request, $autoRetry = true, $maxRetryNumber = 3)
    {
        $requestUrl = $this->composeUrl($request);
        $httpResponse = self::curl($requestUrl, $this->httpMethod, $request->getDomainParameter(), $request->getHeaders());
        
        $retryTimes = 1;
        while (500 <= $httpResponse->getStatus() && $autoRetry && $retryTimes < $maxRetryNumber) {
            $requestUrl = $this->composeUrl($request);
            $httpResponse = self::curl($requestUrl, $this->httpMethod, $request->getDomainParameter(), $request->getHeaders());
            $retryTimes ++;
        }
        $respObject = json_decode($httpResponse->getBody());
        if(false == $httpResponse->isSuccess()) {
            //$this->buildApiException($respObject, $httpResponse->getStatus());
            throw new Exception(" HTTP Status: " . $httpResponse->getStatus() . " RequestID: " . $respObject->RequestId);
        }
        return $respObject;
    }
    
    private function prepareValue($value)
    {
        if (is_bool($value)) {
            if ($value) {
                return "true";
            } else {
                return "false";
            }
        } else {
            return $value;
        }
    }
    
    public function composeUrl($request)
    {
        $apiParams = $request->getQueryParameters();
        foreach ($apiParams as $key => $value) {
            $apiParams[$key] = $this->prepareValue($value);
        }
        $apiParams["RegionId"] = $this->regionId;
        $apiParams["AccessKeyId"] = $this->accessKeyId;
        $apiParams["Format"] = $this->format;
        $apiParams["SignatureMethod"] = $this->signatureMethod;
        $apiParams["SignatureVersion"] = $this->signatureVersion;
        $apiParams["SignatureNonce"] = md5(uniqid(mt_rand(), true));
        $apiParams["Timestamp"] = gmdate($this->dateTimeFormat);
        $apiParams["Action"] = $request->getActionName();
        $apiParams["Version"] = $this->version;
        $apiParams["Signature"] = $this->computeSignature($apiParams);
        if($this->httpMethod == "POST") {
            $requestUrl = $this->protocol."://". $this->domain . "/";
            foreach ($apiParams as $apiParamKey => $apiParamValue){
                $request->putDomainParameters($apiParamKey,$apiParamValue);
            }
            return $requestUrl;
        } else {
            $requestUrl = $this->protocol."://". $this->domain . "/?";
            
            foreach ($apiParams as $apiParamKey => $apiParamValue) {
                $requestUrl .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
            }
            return substr($requestUrl, 0, -1);
        }
    }
    
    private function computeSignature($parameters)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
        }
        $stringToSign = $this->httpMethod.'&%2F&' . $this->percentEncode(substr($canonicalizedQueryString, 1));
        
        return	base64_encode(hash_hmac('sha1', $stringToSign, $this->accessKeySecret."&", true));
    }
    
    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }
    
    public static function curl($url, $httpMethod = "GET", $postFields = null,$headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postFields) ? self::getPostHttpBody($postFields) : $postFields);
        
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        //https request
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_array($headers) && 0 < count($headers)) {
            $httpHeaders =self::getHttpHearders($headers);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$httpHeaders);
        }
        
        $httpResponse = new HttpResponse();
        $httpResponse->setBody(curl_exec($ch));
        $httpResponse->setStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        
        curl_close($ch);
        return $httpResponse;
    }
    public static function getPostHttpBody($postFildes){
        $content = "";
        foreach ($postFildes as $apiParamKey => $apiParamValue)
        {
            $content .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
        }
        return substr($content, 0, -1);
    }
    public static function getHttpHearders($headers)
    {
        $httpHeader = array();
        foreach ($headers as $key => $value)
        {
            array_push($httpHeader, $key.":".$value);
        }
        return $httpHeader;
    }

}
