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
	const TEST_LENGTH = 5;

	/**
	 *  Zwróć zadaną ilosć obrazków z odpowiedniej kategorii
	 *  @Rest\Get("/getQuestionsFromCategoryToDisplay/{category}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getQuestionsFromCategoryToDisplayAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findRandomQuestionsByCategory($category);
		
		if (is_null($questions) || empty($questions) || !$questions[0] instanceof Question) {
			throw $this->createNotFoundException("Nie znaleziono obrazków");
		}
		
		$q = array();
		$d = array();
		$id = array();
		
		foreach($questions as $question) {
			$q[] = $question->getQuestion();
			$d[] = $question->getPicture();
			$id[] = $question->getId();
		}
		
		return new JsonResponse(array(
			'Questions' => $q,
			'PictureDir' => $d,
			'IDs' => $id,
			'CategoryName' => $questions[0]->getCategory()->getName(),
			'Length' => count($questions)
		));
	}
	
	/**
	 *  Zwróć zadaną ilosć randomowych obrazków
	 *  @Rest\Get("/getRandomQuestionsToDisplay")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getRandomQuestionsToDisplayAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findRandomQuestions(ShowPictureController::TEST_LENGTH);
		
		if (is_null($questions) || count($questions) < ShowPictureController::TEST_LENGTH || !$questions[0] instanceof Question) {
			throw $this->createNotFoundException("Zbyt mało obrazków w bazie");
		}

		$q = array();
		$d = array();
		$id = array();
		
		foreach($questions as $question) {
			$q[] = $question->getQuestion();
			$d[] = $question->getPicture();
			$id[] = $question->getId();
		}
		
		return new JsonResponse(array(
			'Questions' => $q,
			'PictureDir' => $d,
			'IDs' => $id,
			'Length' => count($questions)
		));
	}
}