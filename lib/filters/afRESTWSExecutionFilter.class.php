<?php
/**
 * A filter that transforms all returned by action data into json response
 */
class afRESTWSExecutionFilter extends sfExecutionFilter
{
    public function execute($filterChain) {
        try {
            parent::execute($filterChain);
        } catch (Exception $e) {
            $this->injectErrorIntoResponse($e->getMessage());
        }
    }

    protected function handleAction($filterChain, $actionInstance) {
        $returnData = parent::handleAction($filterChain, $actionInstance);
        if (!is_array($returnData)) {
            $place = $actionInstance->getModuleName().'/'.$actionInstance->getActionName();
            throw new afRESTWSException("Data returned by $place should be of type array");
        }

        return $returnData;
    }

    protected function handleView($filterChain, $actionInstance, $returnData) {
        $jsonData = array(
            'success' => true,
            'data' => $returnData
        );
        $this->context->getResponse()->setContent(json_encode($jsonData));
    }

    private function injectErrorIntoResponse($errorMessage)
    {
        $response = $this->context->getResponse();
        $params = array('success' => false, 'message' => $errorMessage);
        $response->setContent(json_encode($params));
    }

}
