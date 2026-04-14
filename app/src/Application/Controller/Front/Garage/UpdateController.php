<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\GarageApp;
use App\Domain\Form\Front\Garage\AppUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
	path: '/{_locale<%app.supported_locales%>}/garage',
	name: 'app.garage.',
	requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG],
	options: ['expose' => false],
	methods: ['GET', 'POST'],
	schemes: ['http', 'https'],
	format: 'html',
	utf8: true
)]
final class UpdateController extends AbstractController
{
	use WebController;

	/** @description link to pages */
	private static array $crud = [
	  'index'  => 'app.garage.index',
	  'create' => 'app.garage.create',
	  'read'   => 'app.garage.read',
	  'update' => 'app.garage.update',
	  'delete' => 'app.garage.delete',
	];

	#[Route('/update/{slug}-{id}.php', name: 'update')]
	public function update(
		EntityManagerInterface $manager,
		EventDispatcherInterface $dispatcher,
		GarageApp $entity,
		Request $request,
	): Response
	{
		### Variables
		$home  = $this->translator->trans('text.garage');
		$title = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();

		### Création du Formulaire
		$form = $this->createForm(AppUpdateType::class, $entity)->handleRequest($request);

		### Vérification des données du formulaire
		if ($form->isSubmitted() && $form->isValid()) {
			try {
				### Event
//                $dispatcher->dispatch(new AppUpdateEvent($entity));

				### Doctrine
				$manager->flush();

				### Flash Message
				$this->addFlash(
					type: 'success',
					message: sprintf($this->translator->trans('notification.updated'), $title),
				);
			} catch (RuntimeException $e) {
				### Flash Message
				$this->addFlash(
					type: 'error',
					message: $this->translator->trans('notification.error'),
				);

				throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
			}

//            ### Launch Command To Generate Garage List YAML
//            $this->generateGarageList();

			### Redirection
			return $this->redirectToRoute(
				route: 'app.garage.update',
				parameters: ['id' => $entity->getId(), 'slug' => $entity->getSlug()],
				status: Response::HTTP_SEE_OTHER
			);
		}

		return $this->render('@App/contents/front/garage/update.html.twig', [
			'container'       => 'container-fluid',
			'breadcrumb'      => self::Breadcrumb($home, $this->translator->trans('text.update')),
			'links'           => self::$crud,
			'controller_name' => $title,
			'current_page'    => $request->attributes->get('_route'),
			'entity'          => $entity,
			'form'            => $form,
		]);
	}
}
