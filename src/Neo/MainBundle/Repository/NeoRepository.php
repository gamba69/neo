<?php
/**
 * User: idulevich
 */

namespace Neo\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class NeoRepository
 *
 * @package Neo\MainBundle\Repository
 */
class NeoRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllHazardousQueryBuilder()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->andWhere('a.hazardous = true')
            ->orderBy('a.date', 'desc');

        return $qb;
    }

    /**
     * @param bool $hazardous
     *
     * @return QueryBuilder
     */
    public function getFastestQueryBuilder($hazardous = false)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->andWhere('a.hazardous = :hazardous')
            ->setParameter('hazardous', $hazardous)
            ->orderBy('a.speed', 'desc')
            ->setMaxResults(1);

        return $qb;
    }
}