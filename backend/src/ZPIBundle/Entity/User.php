<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ZPIBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;
	
	function __construct($l, $p) {
		$this->login=$l;
		$this->password=$p;
	}
	
	function getPassword() {
		return $this->password;
	}
	
	function getLogin() {
		return $this->login;
	}
	
	function getId() {
		return $this->id;
	}
	
	
  
}