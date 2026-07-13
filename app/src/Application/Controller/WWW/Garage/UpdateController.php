<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Garage;

use App\Domain\Entity\GarageApp;
use App\Domain\Form\GarageAppUpdateType;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use App\Infrastructure\Event\Garage\AppEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
	path: '/{_locale<%app.supported_locales%>}/garage',
	name: 'app.garage.',
	requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG, 'mode' => Requirement::ASCII_SLUG],
	options: ['expose' => false],
	methods: ['GET', 'POST'],
	schemes: ['http', 'https'],
	format: 'html',
	utf8: true
)]
final class UpdateController extends AbstractBaseController
{
	/** @description link to pages */
	public static array $crud = [
        'index'  => 'app.garage.index',
        'create' => 'app.garage.create',
        'read'   => 'app.garage.read',
        'update' => 'app.garage.update',
        'delete' => 'app.garage.delete',
	];

	#[Route('/update/{mode}/{id}/{slug}.php',
        name: 'update',
        requirements: ['mode' => 'light|full'],
        defaults: ['mode' => 'light'],
    )]
	public function update(
		EntityManagerInterface $manager,
		EventDispatcherInterface $dispatcher,
		GarageApp $entity,
		Request $request,
        TranslatorInterface $translator,
        string $mode
	): Response
	{
		### Variables
		$dashboard  = $translator->trans('text.dashboard');
		$garage     = $translator->trans('text.garage');
        $current    = $translator->trans('text.update');
		$title      = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();
        $params     = ['id' => $entity->getId(), 'slug' => $entity->getSlug()];
		$breadcrumb = [
			['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
			['label' => $garage,    'route' => 'app.garage.index',    'params' => []],
			['label' => $current,   'route' => 'app.garage.update',   'params' => $params],
		];

		### Création du Formulaire
		$form = $this->createForm(GarageAppUpdateType::class, $entity)->handleRequest($request);

		### Vérification des données du formulaire
		if ($form->isSubmitted() && $form->isValid()) {
			try {
				### Events
                $dispatcher->dispatch(new AppEvent($entity));

				### Doctrine
				$manager->flush();

				### Flash Message
				$this->addFlash(
					type: 'success',
					message: sprintf($translator->trans('notification.updated'), $title),
				);
			} catch (\RuntimeException $e) {
				throw new \RuntimeException("Le formulaire du garage n'est pas valide");
			}

			### Redirection
			return $this->redirectToRoute(
                route: self::$crud['update'],
                parameters: $params,
                status: Response::HTTP_SEE_OTHER
            );
		}

		return $this->render('@App/themes/lte/contents/garage/update.html.twig', [
			'breadcrumb'        => self::breadcrumb($breadcrumb),
			'links'             => self::$crud,
			'controller_name'   => $title,
			'current_page'      => $request->attributes->get('_route'),
            'entity'            => $entity,
            'form'              => $form,
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
            'mode'              => $mode,
		]);
	}
}
