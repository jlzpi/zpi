<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\User;

class UserRepository extends EntityRepository
{
    public function findByLogin($log)
    {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:User');
		
		$query = $rep
			->createQueryBuilder('User')
			->select('User')
			->where('User.login = :log')
			->setParameter('log', $log)
		;
		
        return $query
			->getQuery()
			->getOneOrNullResult() //<- jeden ziomek albo null
			//->getResult() <- tablica
		;
    }
}