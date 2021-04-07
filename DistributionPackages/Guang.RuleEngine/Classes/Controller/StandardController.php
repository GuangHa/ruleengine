<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Guang\RuleEngine\Service\RuleService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use JWadhams;

class StandardController extends ActionController
{

    /**
     * @var RuleService
     * @Flow\Inject
     */
    protected $ruleService;

    /**
     * @return void
     */
    public function indexAction()
    {
        $rule = '';
        $data = '';
        $output = '';
        $ruleCheckOutput = '';
        $dataCheckOutput = '';
        if ($this->request->hasArgument('rule') && $this->request->hasArgument('data')) {
            $rule = $this->request->getArgument('rule');
            $data = $this->request->getArgument('data');
            $ruleCheckOutput = $this->ruleService->checkInput($rule);
            $dataCheckOutput = $this->ruleService->checkInput($data);
            if ($ruleCheckOutput === false && $dataCheckOutput === false) {
                $output = $this->ruleService->applyRules($rule, $data);
            }
        }
        $this->view->assign('rule', $rule);
        $this->view->assign('data', $data);
        $this->view->assign('output', json_encode($output, JSON_PRETTY_PRINT));
        $this->view->assign('ruleCheckOutput', $ruleCheckOutput);
        $this->view->assign('dataCheckOutput', $dataCheckOutput);
        $this->view->assign('runs', $this->ruleService->getRuns());
    }
}
