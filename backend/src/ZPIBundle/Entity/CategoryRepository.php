<?php

namespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ZPIBundle\Entity\Category;

class CategoryRepository extends EntityRepository
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
	
	//zwraca wszystkie kategorie
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