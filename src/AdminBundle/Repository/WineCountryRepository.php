<?php

namespace AdminBundle\Repository;

/**
 * WineCountryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WineCountryRepository extends \Doctrine\ORM\EntityRepository
{


    public function getAll($orderLocale = 'pl') {
        $qb = $this->createQueryBuilder('c')
            ->join('c.translations', 'trans')
            ->where('trans.locale = :locale')
            ->setParameter(':locale', $orderLocale)
            ->orderBy('trans.title')
        ;
        return $qb->getQuery()->getResult();
    }


    /**
     * @param $slug
     */
    public function getBySlug($slug) {
        $qb = $this->createQueryBuilder('c')
            ->join('c.translations', 'trans')
            ->where('trans.slug = :slug')
            ->setParameter(':slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getMaxSort() {
        $qb = $this->createQueryBuilder('wico')
            ->select('MAX(wico.sort) AS max_sort');
        return $qb->getQuery()->getSingleScalarResult();
    }


}
