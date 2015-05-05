<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
	 *
	 *	@Secure(roles="ROLE_STUDENT")
	 */
	public function getCategoriesToDisplayAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$categories = $em->getRepository('ZPIBundle:Category')->findAllCategories();
		
		if (is_null($categories) || empty($categories) || !$categories[0] instanceof Category) {
			throw $this->createNotFoundException("Nie znaleziono kategorii");
		}
		
		foreach($categories as $category) {
			$tab[$category->getId()] = $category->getName();
		}
		
		return new JsonResponse(array(
			'Categories' => $tab
		));
	}
}