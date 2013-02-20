<?php

namespace Enjoy\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


class User extends EntityRepository implements AdvancedUserInterface, \Serializable
{
	protected $id;
	protected $name;
	protected $surname;
	protected $email;
	protected $password;
	protected $salt;
	protected $team;
	protected $roles;
#	protected $created_at;


	public function __construct($email, $password)
	{
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
		$this->email = email;
		$this->password = $password;
		$this->roles = new ArrayCollection();

	}

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
     * @return User
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
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

	public function __toString()
	{
		return $this->name . " " . $this->surname;
	}

    /**
     * Set team
     *
     * @param \Enjoy\UserBundle\Entity\Team $team
     * @return User
     */
    public function setTeam(\Enjoy\UserBundle\Entity\Team $team = null)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return \Enjoy\UserBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }

	public function addRole($role)
	{
		$role = strtoupper($role);
		if ($role === static::ROLE_DEFAULT) {
			return $this;
		}

		if (!in_array($role, $this->roles, true)) {
			$this->roles[] = $role;
		}

		return $this;
	}

	/**
	 * Serializes the user.
	 *
	 * The serialized data have to contain the fields used by the equals method and the username.
	 *
	 * @return string
	 */
	public function serialize()
	{
		return serialize(array(
			$this->password,
			$this->salt,
			$this->id,
		));
	}

	/**
	 * Unserializes the user.
	 *
	 * @param string $serialized
	 */
	public function unserialize($serialized)
	{
		$data = unserialize($serialized);
		// add a few extra elements in the array to ensure that we have enough keys when unserializing
		// older data which does not include all properties.
		$data = array_merge($data, array_fill(0, 2, null));

		list(
			$this->password,
			$this->salt,
			$this->id
			) = $data;
	}

	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Returns the user roles
	 *
	 * @return array The roles
	 */
	public function getRoles()
	{
		return $this->roles->toArray();
	}

	/**
	 * Never use this to check if this user has access to anything!
	 *
	 * Use the SecurityContext, or an implementation of AccessDecisionManager
	 * instead, e.g.
	 *
	 *         $securityContext->isGranted('ROLE_USER');
	 *
	 * @param string $role
	 *
	 * @return boolean
	 */
	public function hasRole($role)
	{
		return in_array(strtoupper($role), $this->getRoles(), true);
	}


	public function isUser(UserInterface $user = null)
	{
		return null !== $user && $this->getId() === $user->getId();
	}

	public function removeRole($role)
	{
		if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
			unset($this->roles[$key]);
			$this->roles = array_values($this->roles);
		}

		return $this;
	}


	public function setRoles(array $roles)
	{
		$this->roles = array();

		foreach ($roles as $role) {
			$this->addRole($role);
		}

		return $this;
	}

	/**
	 * Gets the groups granted to the user.
	 *
	 * @return Collection
	 */
	/*public function getGroups()
	{
		return $this->groups ?: $this->groups = new ArrayCollection();
	}

	public function getGroupNames()
	{
		$names = array();
		foreach ($this->getGroups() as $group) {
			$names[] = $group->getName();
		}

		return $names;
	}

	public function hasGroup($name)
	{
		return in_array($name, $this->getGroupNames());
	}

	public function addGroup(GroupInterface $group)
	{
		if (!$this->getGroups()->contains($group)) {
			$this->getGroups()->add($group);
		}

		return $this;
	}

	public function removeGroup(GroupInterface $group)
	{
		if ($this->getGroups()->contains($group)) {
			$this->getGroups()->removeElement($group);
		}

		return $this;
	}*/

	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		return $this->getEmail();
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 *
	 * @return void
	 */
	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	/**
	 * Checks whether the user's account has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw an AccountExpiredException and prevent login.
	 *
	 * @return Boolean true if the user's account is non expired, false otherwise
	 *
	 * @see AccountExpiredException
	 */
	public function isAccountNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is locked.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a LockedException and prevent login.
	 *
	 * @return Boolean true if the user is not locked, false otherwise
	 *
	 * @see LockedException
	 */
	public function isAccountNonLocked()
	{
		return true;
	}

	/**
	 * Checks whether the user's credentials (password) has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a CredentialsExpiredException and prevent login.
	 *
	 * @return Boolean true if the user's credentials are non expired, false otherwise
	 *
	 * @see CredentialsExpiredException
	 */
	public function isCredentialsNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is enabled.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a DisabledException and prevent login.
	 *
	 * @return Boolean true if the user is enabled, false otherwise
	 *
	 * @see DisabledException
	 */
	public function isEnabled()
	{
		return true;
	}

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }
}