<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\User;
use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="Statistics")
 */
class Statistics
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="statistics")
     * @ORM\JoinColumn(name="question", referencedColumnName="id")
     */
    private $question;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="statistics")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;
	
    /**
     * @ORM\Column(type="integer")
     */
    private $correct;
	
    /**
     * @ORM\Column(type="integer")
     */
    private $incorrect;

	
	public function getUser() {
		return $this->user;
	}
	
	public function getQuestion() {
		return $this->question;
	}
	
	public function getCorrect() {
		return $this->correct;
	}
	
	public function getIncorrect() {
		return $this->incorrect;
	}
		
	public function incrementCorrect() {
		$this->correct++;
	}
	
	public function incrementIncorrect() {
		$this->incorrect++;
	}
}