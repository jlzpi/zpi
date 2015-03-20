<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ZPIBundle\Entity\User;
use ZPIBundle\Entity\UserRepository;

class LogowanieController extends FOSRestController {


	/**
	* Metoda do logowania COKOLWIEK
	* @Rest\Post("/zaloguj")
	* 
	* @ApiDoc(
	 *		section="logowanie",
     *  	parameters={
     *  	    {"name"="login", "dataType"="string", "required"=true, "description"="login jakistam"},
     *  	    {"name"="haslo", "dataType"="string", "required"=true, "description"="hasło jakieśtam"}
     * 	 	}
     *  )
	*/
	public function zalogujAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		
		$login = $request->request->get('login');
		$haslo = $request->request->get('haslo');
		
		$user = $em->getRepository('ZPIBundle:User')->findByLogin($login);
		if (! $user instanceof User) 
			//return;
		$odp='Nie ma takiego użytkownika';
		else {
			if ($user->getPassword()==$haslo)
				$odp='logowanie poprawne';
			else
				$odp='logowanie niepoprawne';
		}
		return new JsonResponse(array(
			'info' => $odp
		));
		
		//return new Response('<html><body>'.$odp.'</body></html>');
		
	}
	
	
	
	/**
	* Metoda do rejestracji COKOLWIEK
	* @Rest\Post("/rejestruj")
	* 
	* @ApiDoc(
	 *		section="logowanie",
     *  	parameters={
     *  	    {"name"="login", "dataType"="string", "required"=true, "description"="login jakistam"},
     *  	    {"name"="haslo", "dataType"="string", "required"=true, "description"="hasło jakieśtam"}
     * 	 	}
     *  )
	*/
	public function rejestrujAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		
		$login = $request->request->get('login');
		$haslo = $request->request->get('haslo');
		
		$user = new User($login, $haslo);
		
		try {
		$em->persist($user);
		$em->flush();
		var_dump($user);
		return new JsonResponse(array(
			'login'=>$login,'haslo'=>$haslo,
			'user'=>$user,
			'info' => 'dodano.'
		));
		}
		catch (Exception $e) {
			return new JsonResponse(array(
			'info' => 'nie dodano. (unique?)'
		));
		}
	}
	
}
