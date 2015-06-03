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

use ZPIBundle\Entity\Category;
use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\User;
use ZPIBundle\Entity\Statistics;
use ZPIBundle\Entity\QuestionRepository;
use ZPIBundle\Entity\StatisticsRepository;

class StatisticsController extends FOSRestController {
	const ANSWER_CORRECT = 1;
	const ANSWER_WRONG = 0;
	
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
		
		$categories = $em->getRepository('ZPIBundle:Category')->findAllCategories();

		if(is_null($categories) || empty($categories) || !$categories[0] instanceof Category) {
			throw $this->createNotFoundException("Nie znaleziono żadnych kategorii");
		}		

		foreach($categories as $category) {
			$unsortedStatsFromCategories[$category->getName()] = array('correct' => 0, 'wrong' => 0, 'notAnswered' => 0);
			$correct[$category->getName()] = 0;
		}

		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findAllUserStatistics($userId);
		
		if(is_null($stats) || empty($stats) || !$stats[0] instanceof Statistics) {
			throw $this->createNotFoundException("Nie znaleziono statystyk podanego użytkownika");
		}
		
		$answered = 0;
		$learned = 0;
		
		foreach($stats as $stat) {
			$statCategory = $stat->getQuestion()->getCategory()->getName();
			
			$unsortedStatsFromCategories[$statCategory]['correct'] += $stat->getCorrect();
			$unsortedStatsFromCategories[$statCategory]['wrong'] += $stat->getWrong();
			$unsortedStatsFromCategories[$statCategory]['notAnswered'] += $stat->getNotAnswered();
			$correct[$statCategory] += $stat->getCorrect();

			if($stat->getCorrect() + $stat->getWrong() > 0) $answered++;
			if($stat->getCorrect() > $stat->getWrong() || $stat->getCorrect() >= 5) $learned++;
		}
		
		arsort($correct);
		foreach($correct as $key => $value) {
			$statsFromCategories[$key]['correct'] = $unsortedStatsFromCategories[$key]['correct'];
			$statsFromCategories[$key]['wrong'] = $unsortedStatsFromCategories[$key]['wrong'];
			$statsFromCategories[$key]['notAnswered'] = $unsortedStatsFromCategories[$key]['notAnswered'];
		}
		
		
		$count = (int)($em->getRepository('ZPIBundle:Question')->getNumberOfQuestions());

		return new JsonResponse(array(
			'StatsFromCategories' => $statsFromCategories,
			'Count' => $count,
			'NotAnswered' => ($count - $answered),
			'Learned' => $learned
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
		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findUserStatisticsFromCategory($userId, $categoryId);
		
		if(is_null($stats) || empty($stats) || !$stats[0] instanceof Statistics) {
			throw $this->createNotFoundException("Nie znaleziono statystyk z wybranej kategorii");
		}
		
		$correct = 0;
		$wrong = 0;
		$notAnswered = 0;
		$answered = 0;
		$learned = 0;
		
		foreach($stats as $stat) {
			$correct = $correct + $stat->getCorrect();
			$wrong = $wrong + $stat->getWrong();
			$notAnswered = $notAnswered + $stat->getNotAnswered();
				
			if($stat->getCorrect() + $stat->getWrong() > 0) $answered++;
			if($stat->getCorrect() > $stat->getWrong() || $stat->getCorrect() >= 5) $learned++;
		}
		
		$count = (int)($em->getRepository('ZPIBundle:Question')->getNumberOfQuestionsFromCategory($categoryId));

		return new JsonResponse(array(
			'AllCorrect' => $correct,
			'AllWrong' => $wrong,
			'AllNotAnswered' => $notAnswered,
			'Count' => $count,
			'NotAnswered' => ($count - $answered),
			'Learned' => $learned
		));
	}

	/**
	 *  Aktualizuj statystyki
	 *  @Rest\Post("/setStatistics")
	 *
	 *	@ApiDoc(
	 *		section="statystyki",
     *  	parameters={
     *  	    {"name"="userId", "dataType"="string", "required"=true, "description"="user id"},
     *  	    {"name"="questionAnswers", "dataType"="string", "required"=true, "description"="statistics to save"}
     * 	 	}
     *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function setStatisticsAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$userId = $request->request->get('userId');
		$questionAnswers = json_decode($request->request->get('questionAnswers'));
		
		foreach($questionAnswers as $id => $answer) {
			$stat = $em->getRepository('ZPIBundle:Statistics')->findStatistics($id, $userId);
			
			if(is_null($stat) || !$stat instanceof Statistics) {
				$question = $em->getRepository('ZPIBundle:Question')->find($id);
				$user = $em->getRepository('ZPIBundle:User')->find($userId);

				$newStat = new Statistics($question, $user);
				if($answer == StatisticsController::ANSWER_CORRECT) $newStat->incrementCorrect();
				else if($answer == StatisticsController::ANSWER_WRONG) $newStat->incrementWrong();
				else $newStat->incrementNotAnswered();
				
				$em->persist($newStat);
			}
			else {
				if($answer == StatisticsController::ANSWER_CORRECT) $stat->incrementCorrect();
				else if($answer == StatisticsController::ANSWER_WRONG) $stat->incrementWrong();
				else $stat->incrementNotAnswered();
			}
		}
		
		$em->flush();
	}
	
	/**
	 *  Wyczyść statystykę ze wszystkich kategorii
	 *  @Rest\Get("/clearStatistics/{userId}")
	 *
	 *  @ApiDoc(
	 *		section="statystyki"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function clearStatisticsAction(Request $request, $userId) {
		$em = $this->getDoctrine()->getManager();
		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findAllUserStatistics($userId);
		
		foreach($stats as $stat) {
			$em->remove($stat);
		}
		
		$em->flush();
	}
	
	/**
	 *  Wyczyść statystykę z danej kategorii
	 *  @Rest\Get("/clearStatisticsFromCategory/{categoryId}/{userId}")
	 *
	 *  @ApiDoc(
	 *		section="statystyki"
	 *  )
	 *  
	 *  @Secure(roles="ROLE_STUDENT")
	 */
	public function clearStatisticsFromCategoryAction(Request $request, $categoryId, $userId) {
		$em = $this->getDoctrine()->getManager();
		
		$stats = $em->getRepository('ZPIBundle:Statistics')->findUserStatisticsFromCategory($userId, $categoryId);
		
		foreach($stats as $stat) {
			$em->remove($stat);
		}
		
		$em->flush();
	}
}
