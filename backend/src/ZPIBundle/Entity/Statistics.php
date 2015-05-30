<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\User;
use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="ZPIBundle\Entity\StatisticsRepository")
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
    private $wrong;
	
    /**
     * @ORM\Column(type="integer")
     */
    private $notAnswered;

    public function __construct($question, $user) {
		$this->question = $question;
		$this->user = $user;
		$this->correct = 0;
		$this->wrong = 0;
		$this->notAnswered = 0;
    }
	
	public function getUser() {
		return $this->user;
	}
	
	public function getQuestion() {
		return $this->question;
	}
	
	public function getCorrect() {
		return $this->correct;
	}
	
	public function getWrong() {
		return $this->wrong;
	}
	
	public function getNotAnswered() {
		return $this->notAnswered;
	}

	public function incrementCorrect() {
		$this->correct++;
	}
	
	public function incrementWrong() {
		$this->wrong++;
	}
	
	public function incrementNotAnswered() {
		$this->notAnswered++;
	}
}