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
		$showSummary = false;

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {

				$task = $form->getData();

				$em = $this->getDoctrine()->getManager();
				$em->persist($task);
				$em->flush();

				$showSummary = true;
			}
		}

		return $this->render('EnjoyTaskBundle:Default:add.html.twig', array(
			'form' => $form->createView(), 'task' => $task, 'show_summary' => $showSummary
		));
	}

	public function saveAction(Request $request)
	{


	}

	public function showAction()
	{
		$tasks = $this->getDoctrine()
					->getRepository('EnjoyTaskBundle:Task')
					->findAll();

		return $this->render('EnjoyTaskBundle:Default:show.html.twig', array(
			'tasks' => $tasks
		));
	}
}
