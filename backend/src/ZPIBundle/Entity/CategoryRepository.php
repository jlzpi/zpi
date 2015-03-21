<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Category;

class CategoryRepository extends EntityRepository
{
	public function findAllCategories() {
		$rep = $this->getEntityManager()->getRepository('ZPIBundle:Category');
		
		$query = $rep
			->createQueryBuilder('Category')
			->select('Category')
		;
		
		return $query
			->getQuery()
			->getResult()
		;
	}
}