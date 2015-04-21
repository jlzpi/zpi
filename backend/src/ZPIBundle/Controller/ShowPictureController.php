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
	 *  Zwróć randomowy obrazek
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

		$questions = $em->getRepository('ZPIBundle:Question')->findQuestions();
		
		if (is_null($questions) || empty($questions)) {
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
	 *  Zwróć obrazek z odpowiedniej kategorii
	 *  @Rest\Get("/getQuestionFromCategoryToDisplay/{category}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getQuestionFromCategoryToDisplayAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findQuestionsByCategory($category);
		
		if (is_null($questions) || empty($questions)) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		else {
			$randomInt = rand(0, count($questions)-1);
			
			return new JsonResponse(array(
				'FindNotNull' => true,
				'questionId' => $questions[$randomInt]->getId(),
				'Question' => $questions[$randomInt]->getQuestion(),
				'PictureDir' => $questions[$randomInt]->getPicture(),
				'CategoryName' => $questions[$randomInt]->getCategory()->getName()
			));
		}
	}
	
	/**
	 *  Zwróć zadaną ilosć obrazków z odpowiedniej kategorii
	 *  @Rest\Get("/getQuestionsFromCategoryToDisplay/{category}/{howMany}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getQuestionsFromCategoryToDisplayAction(Request $request, $category, $howMany) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findRandomQuestionsByCategory($category);
		
		if (is_null($questions) || count($questions) < $howMany || $howMany < 1) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		
		for ($i=0; $i<$howMany; $i++) {
			$q[$i] = $questions[$i]->getQuestion();
			$d[$i] = $questions[$i]->getPicture();
			$id[$i] = $questions[$i]->getId();
		}
		
		return new JsonResponse(array(
			'FindNotNull' => true,
			'Questions' => $q,
			'PictureDir' => $d,
			'IDs' => $id,
		));
	}
	
	/**
	 *  Zwróć zadaną ilosć randomowych obrazków
	 *  @Rest\Get("/getRandomQuestionsToDisplay/{howMany}")
	 *
	 *  @ApiDoc(
	 *		section="wyświetlanie obrazka"
	 *  )
	 *
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getRandomQuestionsToDisplayAction(Request $request, $howMany) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findRandomQuestions();
		
		if (is_null($questions) || count($questions) < $howMany || $howMany < 1) {
			return new JsonResponse(array(
				'FindNotNull' => false
			));
		}
		
		for ($i=0; $i<$howMany; $i++) {
			$q[$i] = $questions[$i]->getQuestion();
			$d[$i] = $questions[$i]->getPicture();
			$id[$i] = $questions[$i]->getId();
		}
		
		return new JsonResponse(array(
			'FindNotNull' => true,
			'Questions' => $q,
			'PictureDir' => $d,
			'IDs' => $id
		));
	}
}