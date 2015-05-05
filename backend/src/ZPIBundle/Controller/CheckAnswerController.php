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
use ZPIBundle\Entity\Answer;
use ZPIBundle\Entity\QuestionRepository;

class CheckAnswerController extends FOSRestController {
	
	/**
	 *	sprawdz odpowiedz
	 *  @Rest\Post("/checkAnswer")
	 *	
	 *	@ApiDoc(
	 *		section="check answer",
     *  	parameters={
     *  	    {"name"="id", "dataType"="string", "required"=true, "description"="question id"},
     *  	    {"name"="answer", "dataType"="string", "required"=true, "description"="answer"}
     * 	 	}
     *  )
	 *
	 *	@Secure(roles="ROLE_STUDENT")
	 */
	public function checkAnswerAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$id = $request->request->get('id');
		$answer = $request->request->get('answer');
		
		$question = $em->getRepository('ZPIBundle:Question')->getQuestionWithAnswers($id);
		
		$correct = false;
		$correctAnswer = null;
		$closest = 0;
		
		foreach($question->getAnswers() as $v) {
			$keyWords = $v->getKeyWords();
			$wyn = $this->checkAnswer($answer, $keyWords);
			if($wyn[0] && !$correct) {
				$correct = true;
				$closest = 0;
			}
			if($wyn[1]>$closest && $correct==$wyn[0]) {
				$closest = $wyn[1];
				$correctAnswer = $v->getAnswer();
			}
		}
		
		return array(
			'correct' => $correct,
			'answer' => $correctAnswer
		);
	}
		
	private function checkAnswer($answer, $keys) {
		$answer = preg_replace('/\s+/', ' ', trim($answer));
		$keys = preg_replace('/\s+/', ' ', trim($keys));
		
		$keys = explode(' ', $keys);
		$answer = explode(' ', $answer);
		$i = 0; $n = count($keys);
		
		$correct = false;
		foreach($answer as $word) {
			if($this->isEqual($word, $keys[$i])) $i++;
			if($i>=$n) {
				$correct = true;
				break;
			}
		}
		
		$wyn = 1;
		foreach($answer as $word) {
			foreach($keys as $key) {
				if($this->isEqual($word, $key)) $wyn++;
			}
		}
		return array($correct, $wyn);
	}
	
	private function isEqual($a, $bb) {
		$bb = explode(';', $bb);
		
		foreach($bb as $b) {
		
			$d = array(array());
			
			for($i=-1; $i<strlen($a); $i++) {
				for($j=-1; $j<strlen($b); $j++) {
					if(min($i,$j)==-1) {
						$d[$i][$j] = max($i,$j)+1;
						continue;
					}
					
					if($a[$i]==$b[$j]) $cost = 0;
					else $cost = 1;
					
					$d[$i][$j] = min(
						$d[$i-1][$j]+1,
						$d[$i][$j-1]+1,
						$d[$i-1][$j-1]+$cost
					);
					if($i>0 && $j>0 && $a[$i]==$b[$j-1] && $a[$i-1]==$b[$j])
						$d[$i][$j] = min(
							$d[$i][$j],
							$d[$i-2][$j-2]+$cost
						);
				}
			}
			
			$odl = $d[strlen($a)-1][strlen($b)-1];
			if($odl<=min(strlen($a), strlen($b))/4 && $odl<=2) return true;
		
		}
		return false;
	}
}
