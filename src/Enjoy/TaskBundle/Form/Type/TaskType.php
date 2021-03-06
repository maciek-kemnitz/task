<?php

namespace Enjoy\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title');
		$builder->add('description');
		$builder->add('author', 'entity', array(
			'class' => 'EnjoyUserBundle:User',

		));
		$builder->add('team', 'entity', array(
			'class' => 'EnjoyUserBundle:Team',

		));

		$builder->add('created_at');

	}

	public function getName()
	{
		return 'task';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Enjoy\TaskBundle\Entity\Task',
			'cascade_validation' => true,
		));
	}
}