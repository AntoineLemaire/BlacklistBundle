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
    public $email;

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

        if (null !== $this->email && BlacklistType::TYPE_DOMAIN !== $this->type) {
            throw new ValidatorException(sprintf('Option "email" must be given only with type="%s"', BlacklistType::TYPE_DOMAIN), ['email']);
        }

        if (null === $this->email) {
            $this->email = false;
        }

        if (BlacklistType::TYPE_DOMAIN === $this->type && !is_bool($this->email)) {
            throw new InvalidOptionsException('Expected boolean for option "email"', ['email']);
        }
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
