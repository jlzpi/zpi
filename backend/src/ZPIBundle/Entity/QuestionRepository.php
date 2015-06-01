<?php
namespace ZPIBundle\Entity;
use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Question;
class QuestionRepository extends EntityRepository
{	
	public function getNumberOfQuestions() {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('COUNT(Question.id)')
		;
		
		return $query
			->getQuery()
			->getSingleScalarResult()
		;
	}

	public function getByQuestionAndCategory($p, $q, $c) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question')
			->where('Question.category = :category')
			->setParameter('category',$c)
			->andWhere('Question.question = :question')
			->setParameter('question',$q)
			->andWhere('Question.picture = :picture')
			->setParameter('picture',$p)
		;
		
		return $query
			->getQuery()
			->getOneOrNullResult()
		;
	}
	
	public function getNumberOfQuestionsFromCategory($category) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('COUNT(Question.id)')
			->where('Question.category = :category')
			->setParameter('category', $category)
		;
		
		return $query
			->getQuery()
			->getSingleScalarResult()
		;
	}

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
	
	public function findRandomQuestionsByCategory($c) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question, RAND() AS HIDDEN rand')
			->where('Question.category = :category')
			->setParameter('category', $c)
			->orderBy('rand')
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
	
	public function findQuestions() {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question')
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
	
	public function getQuestionWithAnswers($id) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question, Answer')
			->where('Question.id = :id')
			->leftJoin('Question.answers', 'Answer')
			->setParameter('id', $id)
		;
		
		return $query
			->getQuery()
			->getOneOrNullResult()
		;
	}
	
	public function findRandomQuestions($limit) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Question');
		
		$query = $rep
			->createQueryBuilder('Question')
			->select('Question, RAND() AS HIDDEN rand')
			->orderBy('rand')
		;
		
		return $query
			->getQuery()
			->setMaxResults($limit)
			->getResult()
		;
	}
}