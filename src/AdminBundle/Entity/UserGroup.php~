<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserGroup
 *
 * @ORM\Table(name="user_group")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserGroupRepository")
 */
class UserGroup
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
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;
    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\User", mappedBy="userGroup")
     */
    protected $users;
    
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add user
     *
     * @param \AdminBundle\Entity\User $user
     *
     * @return UserGroup
     */
    public function addUser(\AdminBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AdminBundle\Entity\User $user
     */
    public function removeUser(\AdminBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return UserGroup
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return UserGroup
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set users
     *
     * @param \AdminBundle\Entity\User $users
     *
     * @return UserGroup
     */
    public function setUsers(\AdminBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }
}
