<?php
/**
 * Object is a holder for all data needed to generate request
 *
 * @author lukas
 */
class afRESTWSRequest
{
    protected $parameters;
    protected $parametersEncoded;
    private $resourceId;
    private $httpMethod;
    private $baseUrl;
    
    function __construct($parameters, $resourceId, $httpMethod)
    {
        $this->parameters = (array)$parameters;
        $this->parametersEncoded = $this->encodeParameters();
        $this->resourceId = $resourceId;
        $this->httpMethod = $httpMethod;
    }

    protected function encodeParameters()
    {
        $parts = array();
        foreach($this->parameters as $key => $value) {
            $parts[] = "$key=$value";
        }
        return join('&',$parts);
    }

    function setBaseUrl($baseUrl)
    {
        $urlReversed = strrev($baseUrl);
        if ($urlReversed[0] != '/') {
            $baseUrl .= '/';
        }
        $this->baseUrl = $baseUrl;
    }

    function getParameters()
    {
        return $this->parameters;
    }

    function getParametersEncoded()
    {
        return $this->parametersEncoded;
    }

    function getResourceId()
    {
        return $this->resourceId;
    }

    function getHttpMethod()
    {
        return $this->httpMethod;
    }

    function getHeaders()
    {
        $headers = array();

        if ($this->httpMethod == 'PUT') {
            if (count($this->parameters) > 0) {
                $contentLength = strlen($this->parametersEncoded);
                $headers[] = "Content-Length: {$contentLength}";
            } else {
                $headers[] = "Content-Length: 0";
            }
        }
        
        return $headers;
    }

    function getUrl()
    {
        $url = "{$this->baseUrl}{$this->resourceId}" . (substr(strrev($this->resourceId),0,1) != '/' ? '/' : '');
        return $url;
    }

}
?>