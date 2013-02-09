<?php

namespace Enjoy\TaskBundle\Controller;
use Enjoy\TaskBundle\Entity\Task;
use Enjoy\TaskBundle\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EnjoyTaskBundle:Default:index.html.twig', array('name' => "wii"));
    }

	public function addAction()
	{
		$task = new Task();


		$form = $this->createForm(new TaskType(), $task);

		return $this->render('EnjoyTaskBundle:Default:add.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
