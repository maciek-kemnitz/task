<?php

namespace Enjoy\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;


class Role implements RoleInterface
{
	private $id;

	private $name;

	private $users;

	const NAME_ADMIN = "admin";

	public function __construct()
	{
		$this->users = new ArrayCollection();
	}

	/**
	 * @see RoleInterface
	 */
	public function getRole()
	{
		return $this->name;
	}
    /**
     * @var \Enjoy\UserBundle\Entity\User
     */
    private $user;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user
     *
     * @param \Enjoy\UserBundle\Entity\User $user
     * @return Role
     */
    public function setUser(\Enjoy\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Enjoy\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}