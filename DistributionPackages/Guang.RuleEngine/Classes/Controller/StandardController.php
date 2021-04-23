<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Guang\RuleEngine\Domain\Repository\LogRepository;
use Guang\RuleEngine\Service\LogService;
use Guang\RuleEngine\Service\RuleService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use JWadhams;

class StandardController extends ActionController
{

    const ENTRY_PER_PAGE = 15;

    /**
     * @var RuleService
     * @Flow\Inject
     */
    protected $ruleService;

    /**
     * @Flow\Inject
     * @var LogService
     */
    protected $logService;

    /**
     * @Flow\Inject
     * @var LogRepository
     */
    protected $logRepository;

    /**
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\NoSuchArgumentException
     */
    public function indexAction()
    {
        $rule = '';
        $data = '';
        $output = '';
        $ruleCheckOutput = '';
        $dataCheckOutput = '';

        if ($this->request->hasArgument('recursive')) {
            $recursive = ($this->request->getArgument('recursive') !== '');
        } else {
            $recursive = true;
        }

        if ($this->request->hasArgument('max') && $this->request->getArgument('max') > 0) {
            $max = $this->request->getArgument('max');
            $this->ruleService->setMaxRecursive($max);
        }

        if ($this->request->hasArgument('rule') && $this->request->hasArgument('data')) {
            $rule = $this->request->getArgument('rule');
            $data = $this->request->getArgument('data');
            $ruleCheckOutput = $this->ruleService->checkInput($rule);
            $dataCheckOutput = $this->ruleService->checkInput($data);
            if ($ruleCheckOutput === false && $dataCheckOutput === false) {
                $output = $this->ruleService->applyRules($rule, $data, false, 0, $recursive);
            }
        }
        $this->view->assign('recursive', $recursive);
        $this->view->assign('rule', $rule);
        $this->view->assign('data', $data);
        $this->view->assign('output', json_encode($output, JSON_PRETTY_PRINT));
        $this->view->assign('ruleCheckOutput', $ruleCheckOutput);
        $this->view->assign('dataCheckOutput', $dataCheckOutput);
        $this->view->assign('runs', $this->ruleService->getRuns());
    }

    /**
     * @param int $page
     */
    public function logAction(int $page = 1)
    {
        $maxPages = (int)ceil($this->logRepository->countAll() / self::ENTRY_PER_PAGE);
        $pages = range(1, ($maxPages > 0 ? $maxPages : 1));
        $this->view->assign('currentPage', $page);
        $this->view->assign('pages', $pages);
        $this->view->assign('lastPage', count($pages));
        $this->view->assign('logs', $this->logService->getLogs($page, self::ENTRY_PER_PAGE));
    }
}
