<?php

namespace AntoineLemaire\BlacklistBundle\Model;

use CommerceGuys\Enum\AbstractEnum;

class BlacklistType extends AbstractEnum
{
    const TYPE_IP     = 'ip';
    const TYPE_EMAIL  = 'email';
    const TYPE_DOMAIN = 'domain';
}
