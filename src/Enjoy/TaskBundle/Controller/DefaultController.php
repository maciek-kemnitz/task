<?php

namespace Enjoy\TaskBundle\Controller;
use Enjoy\TaskBundle\Entity\Task;
use Enjoy\TaskBundle\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {

    }

	public function addAction(Request $request)
	{
		$task = new Task();


		$form = $this->createForm(new TaskType(), $task);

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {

				$task = $form->getData();

				$em = $this->getDoctrine()->getManager();
				$em->persist($task);
				$em->flush();
			}
		}

		return $this->render('EnjoyTaskBundle:Default:add.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function saveAction(Request $request)
	{


	}

	public function showAction()
	{

	}
}
