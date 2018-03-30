<?php

namespace AdminBundle\Repository;

/**
 * CmsGalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CmsGalleryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get max sort value
     * @return mixed
     */
    public function getMaxSort() {
        $qb = $this->createQueryBuilder('r')
            ->select('MAX(r.sort) AS max_sort');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Get active galleries
     * @return array
     */
    public function getActive() {
        $qb = $this->createQueryBuilder('g')
            ->where('g.isActive = 1')
            ->orderBy('g.sort', 'ASC')
            ->addOrderBy('g.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $slug
     */
    public function getBySlug($slug) {
        $qb = $this->createQueryBuilder('g')
            ->join('g.translations', 'trans')
            ->where('trans.slug = :slug')
            ->setParameter(':slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
}
