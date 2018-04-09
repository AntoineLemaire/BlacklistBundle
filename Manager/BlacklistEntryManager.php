<?php

namespace AntoineLemaire\BlacklistBundle\Manager;

use AntoineLemaire\BlacklistBundle\Entity\BlacklistEntry;
use AntoineLemaire\BlacklistBundle\Repository\BlacklistEntryRepository;

class BlacklistEntryManager extends BaseManager
{
    /**
     * @param string $value
     * @param string $type
     *
     * @return bool
     */
    public function isBlacklisted($value, $type)
    {
        $count = (int) $this->getRepository()->getCountBlacklistEntryQueryBuilder($value, $type)->getQuery()->getSingleScalarResult();

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
            $blacklist = new BlacklistEntry();
            $blacklist->setType($type);
            $blacklist->setValue($type);
            $this->update($blacklist);
        }

        return true;
    }

    /**
     * @return BlacklistEntryRepository
     */
    public function getRepository()
    {
        return parent::getRepository();
    }
}
