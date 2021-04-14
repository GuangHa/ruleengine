<?php
namespace Guang\RuleEngine\Domain\Repository;

use Guang\RuleEngine\Domain\Model\Log;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;
use \Neos\Flow\Persistence\Repository;

/**
 * Class LogRepository
 * @package Guang\RuleEngine\Domain\Repository
 * @Flow\Scope("singleton")
 */
class LogRepository extends Repository {

    /**
     * @var array
     */
    protected $defaultOrderings = ['id' => QueryInterface::ORDER_DESCENDING];

    /**
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findAllSortByDateDesc(int $offset = 0, int $limit = 10)
    {
        $query = $this->createQuery();
        $query->setLimit($limit);
        $query->setOffset($offset);

        return $query->execute();
    }

}
