<?php
namespace AdminBundle\Repository;
use AdminBundle\Entity\CmsCategory;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;


class CmsCategoryRepository extends NestedTreeRepository {
    
    /**
     * Get category by slug
     */
    public function getOneBySlug($slug) {
        $qb = $this->createQueryBuilder('c')
            ->join('c.translations', 'trans')
            ->where('trans.slug = :slug')
            ->setParameter(':slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Return whole cmsCategory Tree
     */
    public function getAllTree() {
        $query = $this
            ->createQueryBuilder('cms_category')
            ->orderBy('cms_category.root, cms_category.lft', 'ASC')
            ->getQuery();
        return $query->getResult();
    }



    /**
     * Return active cmsCategory Tree
     */
    public function getActiveTree() {
        $query = $this
            ->createQueryBuilder('cms_category')
            ->where('cms_category.isActive = 1')
            ->orderBy('cms_category.root, cms_category.lft', 'ASC')
            ->getQuery();
        return $query->getResult();
    }


    /**
     * Get Parent categories
     */
    public function getParenCategories() {
        $qb = $this->createQueryBuilder('cat')
            ->where('cat.parent IS NULL')
            ->orderBy('cat.root, cat.lft', 'ASC')
            ->getQuery();
        return $qb->getResult();
    }

    /**
     * Foreign keys array
     * @return array
     */
    public function getParenCategoriesIds() {
        /** @var $cmsCategory CmsCategory */
        $keys = [];
        $parentCategories = $this->getParenCategories();
        foreach ($parentCategories as $cmsCategory) {
            $keys[] = $cmsCategory->getId();
        }
        return $keys;
    }

}