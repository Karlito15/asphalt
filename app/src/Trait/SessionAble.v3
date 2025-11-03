<?php

namespace App\Able;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionAble
{
	public static SessionInterface $session;

	public static string $locale = 'fr';

	public function __construct(private readonly RequestStack $requestStack)
	{
		self::$session = $requestStack->getSession();
	}

	/**
	 * Retourne la Session avec l'attribut "theme"
	 *
	 * @return SessionInterface
	 */
	public static function getSess(): SessionInterface
	{
		$session = self::$session;

		$session->set('locale', self::$locale);

		return $session;
	}

//	/**
//	 * Retourne la date de la dernière session en timestamp
//	 *
//	 * @return int
//	 */
//	public static function getLastUsedSession(): int
//	{
//		return self::getSess()->getMetadataBag()->getLastUsed();
//	}
}
