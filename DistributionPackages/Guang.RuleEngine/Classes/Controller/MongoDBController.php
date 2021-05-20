<?php
namespace Guang\RuleEngine\Controller;

/*
 * This file is part of the Guang.RuleEngine package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Guang\RuleEngine\Service\MongoDBService;

class MongoDBController extends ActionController
{
    /**
     * @var MongoDBService
     * @Flow\Inject
     */
    protected $mongodbService;

    public function initializeAction()
    {
        parent::initializeAction();
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set( 'serialize_precision', -1 );
        }
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        if ($this->request->hasArgument('user') && $this->request->hasArgument('password') && $this->request->hasArgument('server')) {
            $user = $this->request->getArgument('user');
            $password = $this->request->getArgument('password');
            $server = $this->request->getArgument('server');
            $this->mongodbService->setConnection($user, $password, $server);
            $this->redirect('index');
        }

        if ($this->request->hasArgument('databasename')) {
            $this->mongodbService->setDatabase($this->request->getArgument('databasename'));
            $this->redirect('index');
        }

        if ($this->mongodbService->hasConnectionData()) {
            $message = $this->mongodbService->testConnection();
            if (strlen($message) > 0) {
                $this->view->assign('message', $message);
            } else {
                $this->view->assign('databaseNames', $this->mongodbService->getDatabaseNames());
                if ($this->mongodbService->hasDatabaseChoosen()) {
                    $this->view->assign('databaseName', $this->mongodbService->getdatabaseName());
                }
                $this->view->assign('hasConnectionData', $this->mongodbService->hasConnectionData());
                $this->view->assign('connectionData', $this->mongodbService->getConnectionData());
            }
        }
    }

    public function closeAction()
    {
        $this->mongodbService->closeConnection();
        $this->redirect('index');
    }

    public function dataAction(string $collection)
    {
        if ($collection != '') {
            return $this->mongodbService->getData($collection);
        }
        return '';
    }


}
