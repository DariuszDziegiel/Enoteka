<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmsTranslation
 *
 * @ORM\Table(name="cms_translation")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsTranslationRepository")
 */
class CmsTranslation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
