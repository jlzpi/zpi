<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Question;

class QuestionRepository extends EntityRepository
{
/*    public function myFind($id)
    {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Test');
		
		$query = $rep
			->createQueryBuilder('Test')
			->select('Test')
			->where('Test.price = :price')
			->setParameter('price', $p)
		;
		
        return $query
			->getQuery()
			->getOneOrNullResult() //<- jeden ziomek albo null
			//->getResult() <- tablica
		;
    }*/
}