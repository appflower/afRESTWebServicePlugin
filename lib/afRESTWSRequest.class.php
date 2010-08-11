<?php
/**
 * Object is a holder for all data needed to generate request
 *
 * @author lukas
 */
class afRESTWSRequest
{
    private $parameters;
    private $resourceId;
    private $httpMethod;
    
    function __construct($parameters, $resourceId, $httpMethod)
    {
        $this->parameters = $parameters;
        $this->resourceId = $resourceId;
        $this->httpMethod = $httpMethod;
    }

    function getParameters()
    {
        return $this->parameters;
    }

    function getResourceId()
    {
        return $this->resourceId;
    }

    function getHttpMethod()
    {
        return $this->httpMethod;
    }
}
?>