<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Garage;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\GarageBalanceAmount;
use App\Domain\Entity\GarageBalanceDue;
use App\Domain\Entity\GarageBalancePaid;
use App\Domain\Entity\GarageBlueprint;
use App\Domain\Entity\GarageGauntlet;
use App\Domain\Entity\GarageRank;
use App\Domain\Entity\GarageStatActual;
use App\Domain\Entity\GarageStatMax;
use App\Domain\Entity\GarageStatMin;
use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\GarageStatusControl;
use App\Domain\Entity\GarageUpgrade;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Entity\SettingLevel;
use App\Domain\Entity\SettingUnitPrice;
use App\Domain\Form\GarageAppCreateType;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use App\Infrastructure\Event\Garage\SettingEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class CreateController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
        'index'  => 'app.garage.index',
        'create' => 'app.garage.create',
        'read'   => 'app.garage.read',
        'update' => 'app.garage.update',
        'delete' => 'app.garage.delete',
    ];

    #[Route('/create.php', name: 'create')]
    public function create(
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        Request $request,
        TranslatorInterface $translator,
    ): Response
    {
        ### Variables
        $dashboard  = $translator->trans('text.dashboard');
        $garage     = $translator->trans('text.garage');
        $title      = $translator->trans('text.create.car');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index',   'params' => []],
            ['label' => $garage,    'route' => 'app.garage.index',      'params' => []],
            ['label' => $title,     'route' => 'app.garage.create',     'params' => []],
        ];

        ### Création du formulaire
        $garage = new GarageApp();
        $form   = $this->createForm(GarageAppCreateType::class, $garage)->handleRequest($request);

        ### Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $brand = $garage->getSettingBrand()->getName();

                ### Create Garage
                $this->createGarageFromScratch($garage, $manager);

                ### Flash Message
                $this->addFlash(
                    type:'success',
                    message: sprintf($translator->trans('notification.created'), $brand . ' ' . $garage->getModel())
                );
            } catch (\RuntimeException $e) {
                ### Flash Message
                $this->addFlash(
                    type:'error',
                    message: $translator->trans('notification.error')
                );

                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            ### Events Settings
            $dispatcher->dispatch(new SettingEvent($garage));

            ### Redirection
            return $this->redirectToRoute(
                route: self::$crud['index'],
                parameters: [],
                status: Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/themes/lte/contents/garage/create.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'garage'            => $garage,
            'game_update_last'  => $manager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'              => $form,
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }


    private function createGarageFromScratch(GarageApp $garage, EntityManagerInterface $manager): void
    {
        ### Create Entity
        $garage->setCarOrder(99);
        $garage->setStatOrder(99);
        $garage->setLevel(0);
        $garage->setEpic(0);
        $garage->setEvo(0);

        ### Relations
        $garage->setSettingBlueprint($manager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => '000-00-00-00-00-00|000']));
        $garage->setSettingLevel($manager->getRepository(SettingLevel::class)->findOneBy(['slug' => '00|00-00-00']));
        $garage->setSettingUnitPrice($manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => '0000000']));

        $amount = new GarageBalanceAmount();
        $amount->setGarage($garage);
        $manager->persist($amount);

        $due = new GarageBalanceDue();
        $due->setGarage($garage);
        $manager->persist($due);

        $paid = new GarageBalancePaid();
        $paid->setGarage($garage);
        $manager->persist($paid);

        $blueprint = new GarageBlueprint();
        $blueprint->setGarage($garage);
        $manager->persist($blueprint);

        $gauntlet = new GarageGauntlet();
        $gauntlet->setGarage($garage);
        $manager->persist($gauntlet);

        $rank = new GarageRank();
        $rank->setGarage($garage);
        $manager->persist($rank);

        $actual = new GarageStatActual();
        $actual->setGarage($garage);
        $manager->persist($actual);

        $max = new GarageStatMax();
        $max->setGarage($garage);
        $manager->persist($max);

        $min = new GarageStatMin();
        $min->setGarage($garage);
        $manager->persist($min);

        $status = new GarageStatus();
        $status->setGarage($garage);
        $manager->persist($status);

        $control = new GarageStatusControl();
        $control->setGarage($garage);
        $manager->persist($control);

        $upgrade = new GarageUpgrade();
        $upgrade->setGarage($garage);
        $manager->persist($upgrade);

        ### Doctrine
        $manager->persist($garage);
        $manager->flush();
    }
}
