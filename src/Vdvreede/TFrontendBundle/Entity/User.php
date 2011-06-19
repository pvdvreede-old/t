<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vdv\AccountBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */   
    private $id;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */   
    private $email;
    
    /**
     * @var string $openId
     *
     * @ORM\Column(name="open_id", type="string", length=255, nullable=false)
     */
    private $openId;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set openId
     *
     * @param string $openId
     */
    public function setOpenId($openId) {
        $this->openId = $openId;
    }

    /**
     * Get openId
     *
     * @return string $openId
     */
    public function getOpenId() {
        return $this->openId;
    }

    public function equals(\Symfony\Component\Security\Core\User\UserInterface $user) {
        return true;
    }
    
    public function eraseCredentials()
    {
    
    }
    
    public function getPassword() {
        return 'test';
    }
    
    public function getRoles() {
        return array();
    }
    
    public function getSalt() {
        return '';
    }
    
    public function getUsername() {
        return $this->getEmail();
    }
    

}