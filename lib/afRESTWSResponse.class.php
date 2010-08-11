<?php
/**
 * This class is responsible for parsing data returned by response
 *
 * We are assuming that base form of response always has some sort of status and some data
 *
 * @author lukas
 */
class afRestWSResponse
{
    protected $status;
    protected $data;
    protected $response;

    function __construct($responseText)
    {
        $this->response = json_decode($responseText, true);
        if (!is_array($this->response)) {
            throw new DynectSMBException('Could not decode response.');
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
        } else {
            throw new DynectSMBException('Could not determine response status.');
        }
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