<?php

namespace Enjoy\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('EnjoyUserBundle:Default:index.html.twig', array('name' => $name));
	}

	public function showAction()
	{
		/**
		 * @var \Enjoy\UserBundle\Entity\User $user
		 */
		$user = $this->getUser();

		$tasks = $this->getDoctrine()
				 ->getRepository('EnjoyTaskBundle:Task')
				 ->findByTeam($user->getTeam());

		return $this->render('EnjoyUserBundle:Profile:show.html.twig', array("tasks" => $tasks));
	}
}
