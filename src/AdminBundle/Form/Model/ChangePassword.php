<?php
namespace AdminBundle\Form\Model;


use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{

    /**
     * @UserPassword()
     */
    protected $oldPassword;

    /**
     * @Assert\Length(min=6)
     * 
     */
    protected $newPassword;


    public function getOldPassword() {
        return $this->oldPassword;
    }

    public function getNewPassword() {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = trim($newPassword);
    }
    
    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }
    
}