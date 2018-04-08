<?php

namespace AntoineLemaire\BlacklistBundle\Validator\Constraints;

use AntoineLemaire\BlacklistBundle\Manager\BlacklistEntityManager;
use AntoineLemaire\BlacklistBundle\Model\BlacklistType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsNotBlacklistedValidator.
 */
class IsNotBlacklistedValidator extends ConstraintValidator
{
    /**
     * @var BlacklistEntityManager
     */
    protected $blacklistManager;

    /**
     * IsNotBlacklistedValidator constructor.
     *
     * @param BlacklistEntityManager $blacklistManager
     */
    public function __construct(BlacklistEntityManager $blacklistManager)
    {
        $this->blacklistManager = $blacklistManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsNotBlacklisted) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\IsNotBlacklisted');
        }

        if ($constraint->type === BlacklistType::TYPE_EMAIL_DOMAIN && $constraint->isEmail) {

        }

        if ($this->blacklistManager->isBlacklisted($value, $constraint->type)) {
            $this->context->buildViolation($constraint->message)
                ->setParameters([
                    '{{ string }}' => $value,
                    '{{ type }}'   => $constraint->type,
                ])
                ->addViolation();
        }
    }
}
