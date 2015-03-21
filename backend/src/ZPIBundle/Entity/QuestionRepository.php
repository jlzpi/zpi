<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Question;

class QuestionRepository extends EntityRepository
{	
	public function findQuestionsByCategory($c) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question')
			->where('Question.category = :category')
			->setParameter('category', $c)
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
	
	public function findAllQuestions() {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question')
		;
		
		return $query
			->getQuery()
			//->getArrayResult()
			//->getOneOrNullResult()
			->getResult()
		;
	}
}