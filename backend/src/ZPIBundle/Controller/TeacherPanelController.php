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

use ZPIBundle\Entity\Question;
use ZPIBundle\Entity\QuestionRepository;

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
	 *  @Rest\Get("/deletePicture/{pictureName}", 
	 *		requirements={
	 *			"pictureName"="^[a-zA-Z0-9._]+"
	 *		}
	 *	)
	 *
	 *  @ApiDoc(
	 *		section="panel nauczyciela"
	 *  )
	 *
	 *  @Secure(roles="ROLE_TEACHER")
	 */
	public function deletePictureAction(Request $request, $pictureName) {
		$em = $this->getDoctrine()->getManager();

		if(file_exists(TeacherPanelController::PICTURE_URL.$pictureName)) {
			unlink(TeacherPanelController::PICTURE_URL.$pictureName);
			$message = 'picture deleted';
		}
		else $message = 'picture doesn\'t exist';
		
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
}