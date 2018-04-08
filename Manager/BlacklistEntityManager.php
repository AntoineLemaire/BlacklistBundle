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
        return $this->getRepository()->getCountBlacklistQueryBuilder($value, $type)->getQuery()->getScalarResult() > 0;
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
            $this->update(new BlacklistEntity($type, $value));
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
