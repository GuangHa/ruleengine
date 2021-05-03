<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Guang\RuleEngine\Domain\Model\Ruleset;
use Guang\RuleEngine\Domain\Repository\RulesetRepository;
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
     * @Flow\Inject
     * @var RulesetRepository
     */
    protected $rulesetRepository;

    public function initializeAction()
    {
        parent::initializeAction();
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set( 'serialize_precision', -1 );
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function applyAction()
    {
        $this->response->setContentType('application/json');

        $input = file_get_contents('php://input');
        $checkInput = $this->ruleService->checkInput($input);
        if ($checkInput === false) {
            $body = json_decode($input);
            $data = json_encode($body->data);
            $rules = json_encode($body->rules);

            // Get Rule from the database using an identifier
            if (is_numeric($body->rules)) {
                $ruleset = $this->rulesetRepository->findById($body->rules)[0];
                $rules = $ruleset->getRules();
            }

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

    public function addAction()
    {
        $this->response->setContentType('application/json');

        $body = json_decode(file_get_contents('php://input'));
        $name = $body->name;
        $description = $body->description;
        $rules = json_encode($body->rules);

        $ruleset = new Ruleset();
        $ruleset->setName($name);
        $ruleset->setDescription($description);
        $ruleset->setRules($rules);
        $ruleset->setDatetime(new \DateTime());

        $this->rulesetRepository->add($ruleset);

        $response['response'] = 'Regel zur Datenbank hinzgefügt';

        return json_encode($response);

    }

}
