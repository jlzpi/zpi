<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ZPIBundle\Entity\Category;
use ZPIBundle\Entity\CategoryRepository;

class ChooseCategoryController extends FOSRestController {

	/**
	 *  Wyświetl kategorie
	 *  @Rest\Get("/getCategoriesToDisplay")
	 *
	 *  @ApiDoc(
	 *		section="wybieranie kategorii"
	 *  )
	 */
	public function getCategoriesToDisplayAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$categories = $em->getRepository('ZPIBundle:Category')->findAllCategories();
		
		if (count($categories) == 0) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		else {			
			for($i=0;$i<count($categories);$i++){
				$tab[$categories[$i]->getId()] = $categories[$i]->getName();
			}
			return new JsonResponse(array(
				'FindNotNull' => true,			
				'Categories' => $tab
			));
		}
	}
}