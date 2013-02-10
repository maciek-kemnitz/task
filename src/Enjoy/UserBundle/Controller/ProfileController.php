<?php

namespace Enjoy\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('EnjoyUserBundle:Default:index.html.twig', array('name' => $name));
	}

	public function showAction($id)
	{
		return $this->render('EnjoyUserBundle:Default:index.html.twig', array('name' => $name));
	}
}
