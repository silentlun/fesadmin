<?php
/**
 * AcsRequest.php
 * @author: allen
 * @date  2020年5月12日上午11:29:14
 * @copyright  Copyright igkcms
 */
namespace common\components\dysms\lib;

abstract class AcsRequest
{
    protected  $actionName;
	protected  $method;
	protected  $protocolType = "https";
	
	protected $queryParameters = array();
	protected $headers = array();
	
	
	private $domainParameters = array();
	
	function  __construct()
	{
	    $this->headers["x-sdk-client"] = "php/2.0.0";
	    $this->initialize();
	}
	
	private function initialize()
	{
	    $this->setMethod("POST");
	    $this->setAcceptFormat("JSON");
	}

	
	public function getDomainParameter()
	{
	    return $this->domainParameters;
	}
	
	public function putDomainParameters($name, $value)
	{
	    $this->domainParameters[$name] = $value;
	}
	
	public function getVersion()
	{
		return $this->version;
	}
	
	public function setVersion($version)
	{
		$this->version = $version;
	}
	
	public function getProduct()
	{
		return $this->product;
	}
	
	public function setProduct($product)
	{
		$this->product = $product;
	}
	
	public function getActionName()
	{
		return $this->actionName;
	}
	
	public function setActionName($actionName)
	{
		$this->actionName = $actionName;
	}
	
	public function getAcceptFormat()
	{
		return	$this->acceptFormat;
	}
	
	public function setAcceptFormat($acceptFormat)
	{
		$this->acceptFormat = $acceptFormat;
	}
	
	public function getQueryParameters()
	{
		return $this->queryParameters;
	}
	
	public function getHeaders()
	{
		return $this->headers;
	}
	
	public function getMethod()
	{
		return $this->method;
	}
	
	public function setMethod($method)
	{
		$this->method = $method;
	}
	
	public function getProtocol()
	{
		return $this->protocolType;
	}
	
	public function setProtocol($protocol)
	{
		$this->protocolType = $protocol;
	}
	
	public function getRegionId()
	{
		return $this->regionId;
	}
	public function setRegionId($region)
	{
		$this->regionId = $region;
	}
	
	public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    } 
        
        
    public function addHeader($headerKey, $headerValue)
    {
        $this->headers[$headerKey] = $headerValue;
    } 
	
		
}