<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use FOS\RestBundle\Controller\Annotations\View;

use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\Answer;
use ZPIBundle\Entity\QuestionRepository;
use ZPIBundle\Entity\Category;

class TeacherPanelController extends FOSRestController {
	const PICTURE_URL = '../../files/pictures/';
	
	/**
	 *  Zwroc obrazki
	 *  @Rest\Get("/getPictures")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function getPicturesAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		return array(
			'pictures' => array_values(array_diff(scandir(TeacherPanelController::PICTURE_URL), array('.','..')))
		);
	}
	
	/**
	 *  Usun obrazek
	 *  @Rest\Post("/deletePictures")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function deletePicturesAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		foreach($request->request->get('pictures') as $pictureName) {
			if(file_exists(TeacherPanelController::PICTURE_URL.$pictureName)) {
				unlink(TeacherPanelController::PICTURE_URL.$pictureName);
				$message = 'pictures deleted';
			}
			else $message = 'picture doesn\'t exist';
		}
		
		return array(
			'message' => $message
		);
	}
	
	/**
	 *  Dodaj obrazek
	 *  @Rest\Post("/addPicture")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela",
     *  	parameters={
     *  	    {"name"="file", "dataType"="file", "required"=true, "description"="picture"}
     * 	 	}
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function addPictureAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
				
		if(is_null($request->files->get('file'))) {
            throw $this->createNotFoundException('No file');
		}
		
		if($request->files->get('file')->getClientSize() > 1*1024*1024) {
			throw $this->createNotFoundException('File is too large (max file size is 1MB)');
		}
		
		if(!preg_match('/^image\//',$request->files->get('file')->getMimeType())) {
			throw $this->createNotFoundException('File must be a picture');
		}
		
		$name = (count(scandir(TeacherPanelController::PICTURE_URL))-2).'-'.$request->files->get('file')->getClientOriginalName();
		
		$file = $request->files->get('file')->move(
			TeacherPanelController::PICTURE_URL,
			$name
		);
		
		return array(
			'message' => 'picture added',
			'pictureName' => $name
		);
	}
	
	/**
	 *  Wyswietl kategorie
	 *  @Rest\Get("/getCategories")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function getCategoriesAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$categories = $em->getRepository('ZPIBundle:Category')->findAllCategories();
		
		if (is_null($categories) || empty($categories) || !$categories[0] instanceof Category) {
			return array('categories' => array());
		}
		
		foreach($categories as $category) {
			$tab[$category->getId()] = $category->getName();
		}
		
		return array(
			'categories' => $tab
		);
	}
	
	/**
	 *  Usun kategorie
	 *  @Rest\Get("/deleteCategory/{id}",
	 *		requirements={
	 *			"id"="\d+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function deleteCategoryAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();

		$category = $em->getRepository('ZPIBundle:Category')->find($id);
		
		if (is_null($category) || !$category instanceof Category) {
			throw $this->createNotFoundException('Category not found');
		}
		
		$em->remove($category);
		$em->flush();
		
		return array(
			'message' => 'category deleted'
		);
	}
	
	/**
	 *  Dodaj kategorie
	 *  @Rest\Get("/addCategory/{name}")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function addCategoryAction(Request $request, $name) {
		$em = $this->getDoctrine()->getManager();
		
		$category = new Category($name);
		
		$em->persist($category);
		$em->flush();
		
		return array(
			'message' => 'added category',
			'categoryName' => $category->getName()
		);
	}
	
	/**
	 *  Zmien nazwe kategori
	 *  @Rest\Get("/changeCategory/{id}/{name}",
	 *		requirements={
	 *			"id"="\d+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function changeCategoryAction(Request $request, $id, $name) {
		$em = $this->getDoctrine()->getManager();

		$category = $em->getRepository('ZPIBundle:Category')->find($id);
		
		if (is_null($category) || !$category instanceof Category) {
			throw $this->createNotFoundException('Category not found');
		}
		
		$category->setName($name);
		
		$em->persist($category);
		$em->flush();
		
		return array(
			'message' => 'category name changed',
			'categoryName' => $category->getName()
		);
	}
	
	/**
	 *  Wyswietl pytania
	 *  @Rest\Get("/getQuestions/{category}",
	 *		requirements={
	 *			"category"="\d+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 *	
	 *	@View(serializerGroups={"question"})
	 */
	public function getQuestionsAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();

		$questions = $em->getRepository('ZPIBundle:Question')->findQuestionsByCategory($category);
		
		if (is_null($questions) || empty($questions) || !$questions[0] instanceof Question) {
			throw $this->createNotFoundException('Questions not found');
		}
		
		return array(
			'questions' => $questions
		);
	}
	
	/**
	 *  Usun pytanie
	 *  @Rest\Get("/deleteQuestion/{id}")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function deleteQuestionAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();

		$question = $em->getRepository('ZPIBundle:Question')->find($id);
		
		if (is_null($question) || !$question instanceof Question) {
			throw $this->createNotFoundException('Question not found');
		}
		
		$em->remove($question);
		$em->flush();
		
		return array(
			'message' => 'question deleted'
		);
	}
	
	/**
	 *  Dodaj pytanie
	 *  @Rest\Post("/addQuestion/{category}",
	 *		requirements={
	 *			"category"="\d+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela",
     *  	parameters={
     *  	    {"name"="picture", "dataType"="string", "required"=true, "description"="obrazek"},
     *  	    {"name"="question", "dataType"="string", "required"=true, "description"="pytanie"}
     * 	 	}
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function addQuestionAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();
		$_picture = $request->request->get('picture');
		$_question = $request->request->get('question');

		$question = new Question($_picture, $_question, $em->getRepository('ZPIBundle:Category')->find($category));
		
		$em->persist($question);
		$em->flush();
		
		return array(
			'message' => 'question added',
			'questionId' => $question->getId()
		);
	}
	
	/**
	 *  Zmien pytanie
	 *  @Rest\Post("/changeQuestion/{id}")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela",
     *  	parameters={
     *  	    {"name"="picture", "dataType"="string", "required"=true, "description"="obrazek"},
     *  	    {"name"="question", "dataType"="string", "required"=true, "description"="pytanie"}
     * 	 	}
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function changeQuestionAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$_picture = $request->request->get('picture');
		$_question = $request->request->get('question');

		$question = $em->getRepository('ZPIBundle:Question')->find($id);
		
		if (is_null($question) || !$question instanceof Question) {
			throw $this->createNotFoundException('Question not found');
		}
		
		$question->setPicture($_picture);
		$question->setQuestion($_question);
		
		$em->persist($question);
		$em->flush();
		
		return array(
			'message' => 'question modified',
			'questionId' => $question->getId()
		);
	}
	
	/**
	 *  Wyswietl pytanie z odpowiedziami
	 *  @Rest\Get("/getQuestionWithAnswers/{questionId}")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela")
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 *
	 *	@View(serializerGroups={"question_with_answers"})
	 */
	public function getQuestionWithAnswersAction(Request $request, $questionId) {
		$em = $this->getDoctrine()->getManager();
		$answers = $request->request->get('answers');
		$keyWords = $request->request->get('keyWords');

		$question = $em->getRepository('ZPIBundle:Question')->find($questionId);
		
		if (is_null($question) || !$question instanceof Question) {
			throw $this->createNotFoundException('Question not found');
		}
		
		return array(
			'question' => $question
		);
	}
	
	/**
	 *  Modyfikuj odpowiedzi do pytania
	 *  @Rest\Post("/modifyAnswers/{questionId}")
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela",
     *  	parameters={
     *  	    {"name"="answers", "dataType"="array", "required"=true, "description"="odpowiedzi"}
     * 	 	}
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function modifyAnswersAction(Request $request, $questionId) {
		$em = $this->getDoctrine()->getManager();
		$answers = $request->request->get('answers');

		$question = $em->getRepository('ZPIBundle:Question')->find($questionId);
		
		if (is_null($question) || !$question instanceof Question) {
			throw $this->createNotFoundException('Question not found');
		}
		
		foreach($question->getAnswers() as $answer) {
			$em->remove($answer);
		}
		
		$question->resetAnswers();
		foreach($answers as $_answer) {
			$answer = new Answer($question, $_answer['answer'], $_answer['keyWords']);
			$question->addAnswer($answer);
		}
		
		$em->persist($question);
		$em->flush();
		
		return array(
			'message' => 'question answers modified',
			'questionId' => $question->getId()
		);
	}
	
	/**
	 *  Dodaj pytanie z odpowiedzia
	 *  @Rest\Post("/addQuestionWithAnswer/{category}",
	 *		requirements={
	 *			"category"="\d+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela",
     *  	parameters={
     *  	    {"name"="picture", "dataType"="string", "required"=true, "description"="obrazek"},
     *  	    {"name"="question", "dataType"="string", "required"=true, "description"="pytanie"},
     *  	    {"name"="answers", "dataType"="array", "required"=true, "description"="odpowiedzi"}
     * 	 	}
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function addQuestionWithAnswerAction(Request $request, $category) {
		$em = $this->getDoctrine()->getManager();
		$_picture = $request->request->get('picture');
		$_question = $request->request->get('question');
		$answers = $request->request->get('answers');

		$question = $em->getRepository('ZPIBundle:Question')->getByQuestionAndCategory($_picture, $_question, $category);
		if (is_null($question) || !$question instanceof Question) {
			$question = new Question($_picture, $_question, $em->getRepository('ZPIBundle:Category')->find($category));
		}
		
		foreach($answers as $_answer) {
			$answer = new Answer($question, $_answer['answer'], $_answer['keyWords']);
			$question->addAnswer($answer);
		}
		
		$em->persist($question);
		$em->flush();
		
		return array(
			'message' => 'question added/modified',
			'questionId' => $question->getId()
		);
	}
}