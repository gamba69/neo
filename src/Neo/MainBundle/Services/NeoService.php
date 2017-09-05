<?php
/**
 * User: idulevich
 */

namespace Neo\MainBundle\Services;

use Doctrine\ORM\EntityManager;
use Neo\MainBundle\Entity\Neo;

/**
 * Class NeoService
 */
class NeoService
{
    /** @var  EntityManager */
    private $entityManager;

    /**
     * NeoService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param integer $id
     *
     * @return Neo
     */
    public function getOrCreateNeoAsteroid($id)
    {
        if (!empty($asteroid = $this->entityManager->getRepository('NeoMainBundle:Neo')->find($id))) {
            return $asteroid;
        }

        $asteroid = new Neo();
        $asteroid->setReference($id);
        $this->entityManager->persist($asteroid);

        return $asteroid;
    }
}