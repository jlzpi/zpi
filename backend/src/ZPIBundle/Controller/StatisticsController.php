<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\RestBundle\Controller\Annotations\View;
use Doctrine\Common\Util\Debug as dump;

use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\User;
use ZPIBundle\Entity\Statistics;
use ZPIBundle\Entity\QuestionRepository;
use ZPIBundle\Entity\StatisticsRepository;

class StatisticsController extends FOSRestController {
	const ANSWER_CORRECT = 1;
	
	/**
	 *  Oblicz statystykę ze wszystkich kategorii
	 *  @Rest\Get("/getStatistics/{userId}")
	 *
	 *  @ApiDoc(
	 *		section="statystyki"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getStatisticsAction(Request $request, $userId) {
		$em = $this->getDoctrine()->getManager();
		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findAllUserStatistics($userId);
		
		if (is_null($stats) || empty($stats) || !$stats[0] instanceof Statistics) {
			throw $this->createNotFoundException("Nie znaleziono statystyk podanego użytkownika");
		}
		
		$correct = array();
		$incorrect = array();
		$questions = array();
		
		foreach($stats as $stat) {
			$correct[] = $stat->getCorrect();
			$incorrect[] = $stat->getIncorrect();
			$questions[] = $stat->getQuestion()->getId();
		}

		return new JsonResponse(array(
			'Correct' => $correct,
			'Incorrect' => $incorrect,
			'Questions' => $questions,
		));
	}
	
	/**
	 *  Oblicz statystykę z danej kategorii
	 *  @Rest\Get("/getStatisticsFromCategory/{categoryId}/{userId}")
	 *
	 *  @ApiDoc(
	 *		section="statystyki"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function getStatisticsFromCategoryAction(Request $request, $categoryId, $userId) {
		$em = $this->getDoctrine()->getManager();
		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findAllUserStatistics($userId);
		
		if (is_null($stats) || empty($stats) || !$stats[0] instanceof Statistics) {
			throw $this->createNotFoundException("Nie znaleziono statystyk podanego użytkownika");
		}
		
		$correct = array();
		$incorrect = array();
		$questions = array();
		
		foreach($stats as $stat) {
			if($stat->getQuestion()->getCategory()->getId() == $categoryId) {
				$correct[] = $stat->getCorrect();
				$incorrect[] = $stat->getIncorrect();
				$questions[] = $stat->getQuestion()->getId();
			}
		}

		return new JsonResponse(array(
			'Correct' => $correct,
			'Incorrect' => $incorrect,
			'Questions' => $questions,
		));
	}
	
	/**
	 *  Aktualizuj statystykę
	 *  @Rest\Get("/setStatistics/{questionId}/{userId}/{isCorrect}")
	 *
	 *  @ApiDoc(
	 *		section="statystyki"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function setStatisticsAction(Request $request, $questionId, $userId, $isCorrect) {
		$em = $this->getDoctrine()->getManager();
		
		$stat = $em->getRepository('ZPIBundle:Statistics')->findStatistics($questionId, $userId);
		
		if (is_null($stat) || !$stat instanceof Statistics) {
			$question = $em->getRepository('ZPIBundle:Question')->find($questionId);
			$user = $em->getRepository('ZPIBundle:User')->find($userId);

			$newStat = new Statistics($question, $user);
			if($isCorrect == StatisticsController::ANSWER_CORRECT) $newStat->incrementCorrect();
			else $newStat->incrementIncorrect();
			
			$em->persist($newStat);
		}
		else {
			if($isCorrect == StatisticsController::ANSWER_CORRECT) $stat->incrementCorrect();
			else $stat->incrementIncorrect();
		}
		
		$em->flush();
	}
}
