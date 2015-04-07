<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use ZPIBundle\Entity\Category;
use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="ZPIBundle\Entity\QuestionAnswersRepository")
 * @ORM\Table(name="QuestionAnswers")
 */
class QuestionAnswers
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
	 * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
	 * @ORM\JoinColumn(name="question", referencedColumnName="id")
     */
    private $question;
	
    /**
     * @ORM\Column(type="string", length=200)
     */
	private $answer;
	
    /**
     * @ORM\Column(type="string", length=200)
     */
	private $keyWords;
	
	public function getId() {
		return $this->id;
	}
	
	public function getQuestion() {
		return $this->question;
	}
	
	public function setQuestion($question) {
		$this->question = $question;
	}
	
	public function setAnswer($answer) {
		$this->answer = $answer;
	}
	
	public function getAnswer() {
		return $this->answer;
	}
	
	public function setKeyWords($keyWords) {
		$this->keyWords = $keyWords;
	}
	
	public function getKeyWords() {
		return $this->keyWords;
	}
}