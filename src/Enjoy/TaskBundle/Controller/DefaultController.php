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
		$user = $this->getUser();

		$task = new Task();
		$task->setAuthor($user);
		$form = $this->createForm(new TaskType(), $task);
		$showSummary = false;

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {

				$task = $form->getData();

				$em = $this->getDoctrine()->getManager();
				$em->persist($task);
				$em->flush();

				return $this->redirect($this->generateUrl("user_home"));
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
		#$user = $this->get('security.context')->getToken()->getUser();
		$user = $this->getUser();

		$tasks = $this->getDoctrine()
					->getRepository('EnjoyTaskBundle:Task')
					->findAll();

		return $this->render('EnjoyTaskBundle:Default:show.html.twig', array(
			'tasks' => $tasks
		));
	}
}
