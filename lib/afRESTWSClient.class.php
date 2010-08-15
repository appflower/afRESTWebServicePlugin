<?php
/**
 * This class is a REST Web Services client
 *
 * @author lukas
 */
class afRESTWSClient
{
    /**
     * @var afRESTWSResponse
     */
    private $lastResponse;

    private $logger;

    private $baseUrl;

    function setBaseUrl($baseUrl)
    {
        $urlReversed = strrev($baseUrl);
        if ($urlReversed[0] != '/') {
            $baseUrl .= '/';
        }
        $this->baseUrl = $baseUrl;
    }

    protected function getRequestClassName()
    {
        return 'afRESTWSRequest';
    }
    protected function getResponseClassName()
    {
        return 'afRESTWSResponse';
    }

    function createRequest($parameters, $resourceId, $httpMethod = 'GET')
    {
        $className = $this->getRequestClassName();
        $request = new $className($parameters, $resourceId, $httpMethod);
        $request->setBaseUrl($this->baseUrl);
        return $request;
    }

    function send(afRESTWSRequest $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, false);


        $parameters = $request->getParameters();
        if (count($parameters) > 0) {
            $this->logDev("Parameters:\n".print_r($parameters, true));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getParametersEncoded());
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());

        $httpMethod = $request->getHttpMethod();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);

        $url = $request->getUrl();
        curl_setopt($ch, CURLOPT_URL, $url);

        $this->logDev(date('Y-m-d H:i:s')." [$httpMethod] $url");

        $httpResult = curl_exec($ch);

        $httpResultDecoded = json_decode($httpResult, true);
        if (!$httpResultDecoded) {
            $httpResultDecoded = $httpResult;
        }
        $this->logDev("Response:\n" . print_r($httpResultDecoded, true));

        $responseClassName = $this->getResponseClassName();
        $this->lastResponse = new $responseClassName($httpResult);
        return $this->lastResponse;
    }

    function setLogger($logger)
    {
        $this->logger = $logger;
    }
    
    protected function log($message)
    {
        if ($this->logger) {
            $this->logger->log($message);
        }
    }
    
    protected function logDev($message)
    {
        if ($this->logger && sfConfig::get('sf_environment') == 'dev') {
            $this->logger->log($message);
        }
    }

    function getLastResponse()
    {
        return $this->lastResponse;
    }
}
?>
