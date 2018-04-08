<?php

namespace AntoineLemaire\BlacklistBundle\Validator\Constraints;

use AntoineLemaire\BlacklistBundle\Model\BlacklistType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class IsNotBlacklisted.
 *
 * @Annotation
 */
class IsNotBlacklisted extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The value "{{ string }}" for type "{{ type }}" is blacklisted';

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $isEmail;

    /**
     * IsNotBlacklisted constructor.
     *
     * @param null|string|array $options
     */
    public function __construct($options = null)
    {
        if (null !== $options && !is_array($options)) {
            $options = [
                'type' => $options,
            ];
        }

        parent::__construct($options);

        if (null === $this->type) {
            throw new MissingOptionsException(sprintf('Option "type" is missing for constraint %s', __CLASS__), ['type']);
        }

        if (!BlacklistType::exists($this->type)) {
            throw new InvalidOptionsException(sprintf('Invalid value for option "type" in constraint %s. Known types are: "%s"', __CLASS__, implode(BlacklistType::getAll())), ['type']);
        }

        if (null !== $this->isEmail && BlacklistType::TYPE_EMAIL_DOMAIN !== $this->type) {
            throw new ValidatorException('Option "isEmail" must be given only with type="email_domain"', ['isEmail']);
        }

        if (BlacklistType::TYPE_EMAIL_DOMAIN === $this->type && !is_bool($this->isEmail)) {
            throw new InvalidOptionsException('Expected boolean for option "isEmail"', ['isEmail']);
        }
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}