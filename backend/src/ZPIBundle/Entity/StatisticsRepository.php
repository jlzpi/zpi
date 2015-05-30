<?php
namespace ZPIBundle\Entity;
use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Statistics;
use ZPIBundle\Entity\Question;
class StatisticsRepository extends EntityRepository
{
	public function findStatistics($questionId, $userId) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Statistics');
		
		$query = $rep
			->createQueryBuilder('Statistics')
			->select('Statistics')
			->where('Statistics.question = :questionId')
			->andWhere('Statistics.user = :userId')
			->setParameters(array('questionId' => $questionId, 'userId' => $userId))
		;
		
		return $query
			->getQuery()
			->getOneOrNullResult()
		;
	}
	
	public function findAllUserStatistics($userId) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Statistics');
		
		$query = $rep
			->createQueryBuilder('Statistics')
			->select('Statistics')
			->where('Statistics.user = :userId')
			->setParameter('userId', $userId)
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
	
	public function findUserStatisticsFromCategory($userId, $categoryId) {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Statistics');
		
		$query = $rep
			->createQueryBuilder('Statistics')
			->select('Statistics, Question')
			->where('Statistics.user = :userId')
			->andWhere('Question.category = :categoryId')
			->innerJoin('Statistics.question', 'Question')
			->setParameters(array('categoryId' => $categoryId, 'userId' => $userId))
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
}