<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;

use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\QuestionRepository;

class ShowPictureController extends FOSRestController {

	/**
	 *  Zwróć randomowy obrazek do wyświetlenia
	 *  @Rest\Get("/getRandomQuestionToDisplay")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *
	 *	@Secure(roles="ROLE_STUDENT")
	 */
	public function getRandomQuestionToDisplayAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findAllQuestions();
		
		if (count($questions) == 0) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		else {
			$randomInt = rand(0, count($questions)-1);
			
			return new JsonResponse(array(
				'FindNotNull' => true,
				'Question' => $questions[$randomInt]->getQuestion(),
				'PictureDir' => $questions[$randomInt]->getPicture(),
				'CategoryName' => $questions[$randomInt]->getCategory()->getName()
			));
		}
	}
	/**
	 *  Zwróć obrazek z odpowiedniej kategorii do wyświetlenia
	 *  @Rest\Get("/getQuestionFromCategoryToDisplay/{category}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getQuestionFromCategoryToDisplayAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findQuestionsByCategory($category);
		
		if (count($questions) == 0) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		else {
			$randomInt = rand(0, count($questions)-1);
			
			return new JsonResponse(array(
				'FindNotNull' => true,
				'Question' => $questions[$randomInt]->getQuestion(),
				'PictureDir' => $questions[$randomInt]->getPicture(),
				'CategoryName' => $questions[$randomInt]->getCategory()->getName()
			));
		}
	}
	
		/**
	 *  Zwróć zadaną ilosć obrazków z odpowiedniej kategorii
	 *  @Rest\Get("/getQuestionFromCategoryToDisplay/{category}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getQuestionFromCategoryToDisplayAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findQuestionsByCategory($category);
		
		if (count($questions) == 0) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		else {
			$randomInt = rand(0, count($questions)-1);
			
			return new JsonResponse(array(
				'FindNotNull' => true,
				'Question' => $questions[$randomInt]->getQuestion(),
				'PictureDir' => $questions[$randomInt]->getPicture(),
				'CategoryName' => $questions[$randomInt]->getCategory()->getName()
			));
		}
	}
}