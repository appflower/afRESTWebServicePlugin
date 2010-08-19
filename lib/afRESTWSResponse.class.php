<?php
/**
 * This class is responsible for parsing data returned by response
 *
 * We are assuming that base form of response always has some sort of status and some data
 *
 * @author lukas
 */
class afRESTWSResponse
{
    protected $status;
    protected $data;
    protected $response;
    protected $message;

    function __construct($responseText)
    {
        $this->response = json_decode($responseText, true);
        if (!is_array($this->response)) {
            throw new afRESTWSException('Could not decode response.');
        }

        $this->parseStatus();
        $this->parseData();
        $this->parseAdditionalData();
    }

    protected function parseAdditionalData()
    {
    }

    protected function parseStatus()
    {
        if (isset($this->response['success'])) {
            $this->status = (bool)$this->response['success'];
            if (isset($this->response['message'])) {
                $this->message = $this->response['message'];
            }
        } else {
            throw new afRESTWSException('Could not determine response status.');
        }
    }

    function getMessage()
    {
        return $this->message;
    }

    protected function parseData()
    {
        if (isset($this->response['data'])) {
            $this->data = $this->response['data'];
        }
    }

    function getData()
    {
        return $this->data;
    }

    function getStatus()
    {
        return $this->status;
    }
    
    function isSuccess()
    {
        return $this->status;
    }
}
?>