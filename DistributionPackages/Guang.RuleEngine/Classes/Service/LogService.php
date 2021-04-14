<?php
namespace Guang\RuleEngine\Service;

use Guang\RuleEngine\Domain\Model\Log;
use Guang\RuleEngine\Domain\Repository\LogRepository;
use Neos\Flow\Annotations as Flow;

class LogService {

    /**
     * @Flow\Inject
     * @var LogRepository
     */
    protected $logRepository;

    public function log(string $message, string $logLevel, string $data, string $rules)
    {
        $log = new Log();
        $log->setDatetime(new \DateTime());
        $log->setMessage($message);
        $log->setDataInput($data);
        $log->setRuleInput($rules);
        $log->setLogLevel($logLevel);
        $this->logRepository->add($log);
    }

    /**
     * @param int $page
     * @param int $logPerPage
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function getLogs(int $page = 1, int $logPerPage = 10)
    {
        $offset = ($page - 1) * $logPerPage;
        return $this->logRepository->findAllSortByDateDesc($offset, $logPerPage);
    }
}
