<?php

namespace Enjoy\UserBundle\Service;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Blowfish implements PasswordEncoderInterface
{

	public function encodePassword($raw, $key)
	{
		if (null === $key)
		{
			$key = '$2a$06$' . md5(substr(uniqid() . time(), 0, 25));
		}

		return crypt($raw, $key);
	}

	public function isPasswordValid($encoded, $raw, $salt)
	{
		return $encoded === $this->encodePassword($raw, $encoded);
	}

}