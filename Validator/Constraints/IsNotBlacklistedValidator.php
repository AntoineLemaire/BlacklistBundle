<?php

namespace AntoineLemaire\BlacklistBundle\Validator\Constraints;

use AntoineLemaire\BlacklistBundle\Manager\BlacklistEntryManager;
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
     * @var BlacklistEntryManager
     */
    protected $blacklistManager;

    /**
     * IsNotBlacklistedValidator constructor.
     *
     * @param BlacklistEntryManager $blacklistManager
     */
    public function __construct(BlacklistEntryManager $blacklistManager)
    {
        $this->blacklistManager = $blacklistManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsNotBlacklisted) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\IsNotBlacklisted');
        }

        if (BlacklistType::TYPE_DOMAIN === $constraint->type && $constraint->email) {
            if (false !== ($email = filter_var($value, FILTER_VALIDATE_EMAIL))) {
                $value = substr(strrchr($email, '@'), 1);
            }
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
