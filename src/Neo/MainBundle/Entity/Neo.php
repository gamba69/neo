<?php
/**
 * User: idulevich
 */

namespace Neo\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Neo
 *
 * @ORM\Table(name="neo_asteroids", options={"comment":"NEO asteroids"})
 * @ORM\Entity(repositoryClass="Neo\MainBundle\Repository\NeoRepository")
 */
class Neo
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", options={"comment":"NEO observation date"})
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", options={"comment":"NEO reference ID"})
     * @ORM\Id()
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", options={"comment":"NEO name"})
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="speed", type="float", options={"comment":"NEO speed"})
     */
    private $speed;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hazardous", type="boolean", options={"comment":"Is NEO hazardous?"})
     */
    private $hazardous;

    /**
     * @param DateTime $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param float $speed
     *
     * @return $this
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param bool $hazardous
     *
     * @return $this
     */
    public function setHazardous($hazardous)
    {
        $this->hazardous = $hazardous;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHazardous()
    {
        return $this->hazardous;
    }
}