<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Guang\RuleEngine\Service\ApiService;
use Guang\RuleEngine\Service\RuleService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class ApiController extends ActionController
{

    /**
     * @Flow\Inject
     * @var RuleService
     */
    protected $ruleService;

    /**
     * @Flow\Inject
     * @var ApiService
     */
    protected $apiService;

    /**
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\NoSuchArgumentException
     */
    public function applyAction()
    {
        $this->response->setContentType('application/json');

        $input = file_get_contents('php://input');
        $checkInput = $this->ruleService->checkInput($input);
        if ($checkInput === false) {
            $body = json_decode($input);
            $data = json_encode($body->data);;
            $rules = json_encode($body->rules);

            $maxRecursive = 100;
            if (property_exists($body, 'maxRecursive')) {
                $maxRecursive = $body->maxRecursive;
            }

            $runRecursive = true;
            if (property_exists($body, 'runRecursive')) {
                $runRecursive = $body->runRecursive;
            }

            $this->ruleService->setMaxRecursive($maxRecursive);
            $output = $this->ruleService->applyRules($rules, $data, false, 0, $runRecursive);
            return json_encode($output);
        }
        $this->apiService->addError('input', $checkInput);
        return $this->apiService->getErrorOutput();
    }

}
