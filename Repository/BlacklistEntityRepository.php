<?php

namespace AntoineLemaire\BlacklistBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class BlacklistEntityRepository extends EntityRepository
{
    /**
     * @param string $value
     * @param string $type
     *
     * @return QueryBuilder
     */
    public function getCountBlacklistQueryBuilder($value, $type)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('COUNT(b)')
            ->where('b.value = :value')
            ->andWhere('b.type = :type')
            ->setParameters([
                'value' => $value,
                'type'  => $type,
            ])
        ;

        return $qb;
    }
}
