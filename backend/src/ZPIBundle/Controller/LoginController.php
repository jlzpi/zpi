<?php

namespace ZPIBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as JMS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

use ZPIBundle\Entity\User;

class LoginController extends FOSRestController {
	
	/**
	 *	Zalogowanie
	 *  @Rest\Post("/login")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie",
     *  	parameters={
     *  	    {"name"="login", "dataType"="string", "required"=true, "description"="login"},
     *  	    {"name"="password", "dataType"="string", "required"=true, "description"="haslo"}
     * 	 	}
     *  )
	 */
	public function loginAction(Request $request) {
		$um = $this->get('fos_user.user_manager');
		
		$user = $um->findUserByUserName($request->request->get('login'));
		if(!$user instanceof User){
            throw $this->createNotFoundException("Wrong login or password");
        }
		
		$encoder = $this->get('security.encoder_factory')->getEncoder($user);
        if(!$encoder || !$encoder->isPasswordValid($user->getPassword(), $request->request->get('password'), $user->getSalt())) {
            throw $this->createNotFoundException("Wrong login or password");
        }
		
        $security = $this->get('security.context');
        $providerKey = $this->container->getParameter('fos_user.firewall_name');
        $roles = $user->getRoles();
        $token = new UsernamePasswordToken($user, null, $providerKey, $roles);
        $security->setToken($token);
		
		return new JsonResponse(array(
			'result' => 'success'
		));
	}
	
	/**
	 *	Wylogowanie
	 *  @Rest\Get("/logout")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie"
     *  )
	 */
	public function logoutAction(Request $request) {
        $security = $this->get('security.context');
        $security->setToken(null);
		
		return new JsonResponse(array(
			'result' => 'success'
		));
	}
	
	/**
	 *	Czy uczen
	 *  @Rest\Get("/isStudent")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie"
     *  )
	 */
	public function isStudentAction(Request $request) {
        $security = $this->get('security.context');
		$user = $security->getToken()->getUser();
		
		if(!$user instanceof User) $result = false;
		else $result = $user->hasRole('ROLE_STUDENT');
				
		return new JsonResponse(array(
			'result' => $result
		));
	}
	
	/**
	 *	Czy nauczyciel
	 *  @Rest\Get("/isTeacher")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie"
     *  )
	 */
	public function isTeacherAction(Request $request) {
        $security = $this->get('security.context');
		$user = $security->getToken()->getUser();
		
		if(!$user instanceof User) $result = false;
		else $result = $user->hasRole('ROLE_TEACHER');
				
		return new JsonResponse(array(
			'result' => $result
		));
	}
	
	/**
	 *	get username
	 *  @Rest\Get("/getUsername")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie"
     *  )
	 */
	public function getUsernameAction(Request $request) {
        $security = $this->get('security.context');
		$user = $security->getToken()->getUser();
		
		if(!$user instanceof User) $result = null;
		else $result = $user->getUsername();
				
		return new JsonResponse(array(
			'result' => $result
		));
	}
}
