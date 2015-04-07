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
	 *
	 *	@View(serializerGroups={"username_and_roles"})
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
		
		return array(
			'result' => 'success',
			'user' => $user
		);
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
		
		return array(
			'result' => 'success'
		);
	}
	
	/**
	 *	get user
	 *  @Rest\Get("/getUser")
	 *	
	 *	@ApiDoc(
	 *		section="logowanie"
     *  )
	 *
	 *	@View(serializerGroups={"username_and_roles"})
	 */
	public function getUsernameAction(Request $request) {
        $security = $this->get('security.context');
		$user = $security->getToken()->getUser();
		
		if(!$user instanceof User) {
			throw $this->createNotFoundException("User not found");
		}
		
		return array(
			'user' => $user
		);
	}
}
