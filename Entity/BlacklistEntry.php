<?php

namespace AntoineLemaire\BlacklistBundle\Entity;

use AntoineLemaire\BlacklistBundle\Model\BlacklistType;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AntoineLemaire\BlacklistBundle\Repository\BlacklistEntryRepository")
 * @ORM\Table("blacklist",
 *    indexes={@ORM\Index(name="blacklist_idx", columns={"value", "type"})},
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="blacklist_unique",
 *            columns={"value", "type"})
 *    }
 * )
 */
class BlacklistEntry
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=25, nullable=false)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        BlacklistType::assertExists($type);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
