<?php
/**
 * Object is a holder for all data needed to generate request
 *
 * @author lukas
 */
class afRESTWSRequest
{
    private $parameters;
    private $parametersEncoded;
    private $resourceId;
    private $httpMethod;
    private $baseUrl;
    
    function __construct($parameters, $resourceId, $httpMethod)
    {
        $this->parameters = $parameters;
        $this->parametersEncoded = json_encode($parameters);
        $this->resourceId = $resourceId;
        $this->httpMethod = $httpMethod;
    }

    function setBaseUrl($baseUrl)
    {
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
        $headers = array('Content-Type: application/json');

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