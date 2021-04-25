<?php
namespace Guang\RuleEngine\Domain\Repository;

use Guang\RuleEngine\Domain\Model\Ruleset;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;
use \Neos\Flow\Persistence\Repository;

/**
 * Class RulesetRepository
 * @package Guang\RuleEngine\Domain\Repository
 * @Flow\Scope("singleton")
 */
class RulesetRepository extends Repository {

    /**
     * @param int $offset
     * @param int $limit
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findAllRulesets(int $offset = 0, int $limit = 10)
    {
        $query = $this->createQuery();
        $query->setLimit($limit);
        $query->setOffset($offset);

        return $query->execute();
    }

}
