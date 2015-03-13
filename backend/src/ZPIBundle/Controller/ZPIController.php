<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ZPIBundle\Entity\Test;
use ZPIBundle\Entity\TestRepository;

class ZPIController extends FOSRestController {

	/**
	 *	Test
	 *  @Rest\Get("/test/{id}",
	 *		requirements={
	 *			"id" = "\d+"
	 *		}
	 *	)
	 *	
	 *	@ApiDoc(
	 *		section="test"
     *  )
	 */
	public function testAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		
		
		
		return new JsonResponse(array(
			'test' => 'test',
			'id' => $id,
			'testid' => $request->query->all()
		));
	}
	
	/**
	 *	Test
	 *  @Rest\Post("/test/dodaj")
	 *	
	 *	@ApiDoc(
	 *		section="test",
     *  	parameters={
     *  	    {"name"="name", "dataType"="string", "required"=true, "description"="name"},
     *  	    {"name"="price", "dataType"="string", "required"=true, "description"="price"},
     *  	    {"name"="description", "dataType"="string", "required"=true, "description"="description"}
     * 	 	}
     *  )
	 */
	public function testDodajAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$test = new Test();
		$test->name = $request->request->get('name');
		$test->price = $request->request->get('price');
		$test->description = $request->request->get('description');
		
		$em->persist($test);
		$em->flush();
		
		return new JsonResponse(array(
			"dodano",
			'Test' => $test
		));
	}
	
	/**
	 *	Test
	 *  @Rest\Get("/test/zoba")
	 *	
	 *	@ApiDoc(
	 *		section="test"
     *  )
	 */
	public function testZobaAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$test = $em->getRepository('ZPIBundle:Test')->find(1);
		$test2 = $em->getRepository('ZPIBundle:Test')->myFind(4.52);
		
		return new JsonResponse(array(
			'Test' => $test,
			'Test2' => $test2
		));
	}
	
	/**
	 *	Test
	 *  @Rest\Get("/test/costam")
	 *	
	 *	@ApiDoc(
	 *		section="test"
     *  )
	 */
	public function testcostamAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		
		return new JsonResponse(array(
			'Test' => 'hejo'
		));
	}
}
