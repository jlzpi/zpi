<?php

namespace ZPIBundle\Entity;

use FOS\UserBundle\Entity\User as CoreUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use ZPIBundle\Entity\Statistics;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends CoreUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
	 * @Groups({"username_and_roles"})
	 */
	protected $username;
	
	/**
	 * @Groups({"username_and_roles"})
	 */
	protected $roles;
	
	/**
	 * @ORM\OneToMany(targetEntity="Statistics", mappedBy="user")
	 */
	protected $statistics;

    public function __construct() {
        parent::__construct();
		$this->statistics = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	public function getId() {
		return $this->id;
	}
}