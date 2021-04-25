<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Guang\RuleEngine\Domain\Model\Ruleset;
use Guang\RuleEngine\Domain\Repository\RulesetRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class RulesetController extends ActionController
{

    /**
     * @Flow\Inject
     * @var RulesetRepository
     */
    protected $rulesetRepository;

    const ENTRY_PER_PAGE = 15;

    /**
     * @param int $page
     * @return void
     */
    public function indexAction(int $page = 1)
    {
        $maxPages = (int)ceil($this->rulesetRepository->countAll() / self::ENTRY_PER_PAGE);
        $pages = range(1, ($maxPages > 0 ? $maxPages : 1));
        $this->view->assign('currentPage', $page);
        $this->view->assign('pages', $pages);
        $this->view->assign('lastPage', count($pages));
        $this->view->assign('rulesets', $this->rulesetRepository->findAllRulesets(($page - 1) * self::ENTRY_PER_PAGE, self::ENTRY_PER_PAGE));
    }

    /**
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * @param Ruleset $ruleset
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Ruleset $ruleset)
    {
        $ruleset->setDatetime(new \DateTime());
        $this->rulesetRepository->add($ruleset);
        $this->redirect('index');
    }

    /**
     * @param Ruleset $ruleset
     */
    public function editAction(Ruleset $ruleset)
    {
        $this->view->assign('ruleset', $ruleset);
    }

    /**
     * @param Ruleset $ruleset
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateAction(Ruleset $ruleset)
    {
        $this->rulesetRepository->update($ruleset);
        $this->redirect('index');
    }

    /**
     * @param Ruleset $ruleset
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(Ruleset $ruleset)
    {
        $this->rulesetRepository->remove($ruleset);
        $this->persistenceManager->persistAll();
        $this->redirect('index');
    }

    public function ruleAction(int $id)
    {
        if ($id > 0) {
            $ruleset = $this->rulesetRepository->findById($id)[0];
            return $ruleset->getRules();
        }
        return '';
    }

}
