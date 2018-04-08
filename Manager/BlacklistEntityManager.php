<?php

namespace AntoineLemaire\BlacklistBundle\Manager;

use AntoineLemaire\BlacklistBundle\Entity\BlacklistEntity;
use AntoineLemaire\BlacklistBundle\Repository\BlacklistEntityRepository;

class BlacklistEntityManager extends BaseManager
{
    /**
     * @param string $value
     * @param string $type
     *
     * @return bool
     */
    public function isBlacklisted($value, $type)
    {
        $count = (int) $this->getRepository()->getCountBlacklistQueryBuilder($value, $type)->getQuery()->getSingleScalarResult();

        return $count > 0;
    }

    /**
     * @param string $value
     * @param string $type
     *
     * @return bool
     */
    public function blacklist($value, $type)
    {
        if (!$this->isBlacklisted($value, $type)) {
            $blacklist = new BlacklistEntity();
            $blacklist->setType($type);
            $blacklist->setValue($type);
            $this->update($blacklist);
        }

        return true;
    }

    /**
     * @return BlacklistEntityRepository
     */
    public function getRepository()
    {
        return parent::getRepository();
    }
}
