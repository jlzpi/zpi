<?php

namespace ZPIBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use ZPIBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
		$um = $this->container->get('fos_user.user_manager');
		
		$student = $um->createUser();
		$student->setUsername('uczen');
		$student->setEmail('uczen@zpi.pl');
		$student->setPlainPassword('asdf');
		$student->setEnabled(true);
		$student->addRole('ROLE_STUDENT');
		
		$teacher = $um->createUser();
		$teacher->setUsername('nauczyciel');
		$teacher->setEmail('nauczyciel@zpi.pl');
		$teacher->setPlainPassword('asdf');
		$teacher->setEnabled(true);
		$teacher->addRole('ROLE_TEACHER');
		
		$um->updateUser($student);
		$um->updateUser($teacher);
    }
	
	/**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
	
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}