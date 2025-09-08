<?php

namespace App\Controller\Web;

use App\Form\Dashboard\InventoryType;
use App\Repository\GarageBooleanRepository;
use App\Service\Cache\InventoryCacheService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], methods: ['GET', 'POST'], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly GarageBooleanRepository $booleans,
        private readonly InventoryCacheService $inventoryCache,
    ) {}

    /**
     * @param Request $request
     * @return Response
     * @throws InvalidArgumentException
     */
	#[Route('{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request): Response
    {
        $title          = $this->translator->trans('controllerName.app.dashboard.index');
        $database       = $this->inventoryCache->createDataCache('inventories');
        $formCredit     = $this->createForm(InventoryType::class, $database['credits'])->handleRequest($request);
        $formToken      = $this->createForm(InventoryType::class, $database['tokens'])->handleRequest($request);
        $formEpic       = $this->createForm(InventoryType::class, $database['epics'])->handleRequest($request);
        $formOverlock   = $this->createForm(InventoryType::class, $database['overlocks'])->handleRequest($request);

        return $this->render('@App/app/dashboard/index.html.twig', [
            'controller_name'   => $title,
            'breadcrumb'        => $title,
	        'formCredit'        => $formCredit,
	        'formToken'         => $formToken,
	        'formEpic'          => $formEpic,
	        'formOverlock'      => $formOverlock,
	        'commons'           => $database['commons'],
	        'rares'             => $database['rares'],
	        'jokers'            => $database['jokers'],
	        'total'             => $this->getTotal(),
	        'unlock'            => $this->getUnlock(),
	        'locked'            => $this->getLocked(),
	        'gold'              => $this->getGold(),
	        'toUnlock'          => $this->getToUnlock(),
	        'toUpgrade'         => $this->getToUpgrade(),
	        'toGold'            => $this->getToGold(),
        ]);
    }

	#[Route('/', name: 'noLocale')]
	public function indexNoLocale(): Response
	{
		return $this->redirectToRoute('app.dashboard.index', [
            '_locale' => 'fr'
        ], Response::HTTP_PERMANENTLY_REDIRECT);
	}

    /**
     * @return array<string, int>
     */
    private function getTotal(): array
    {
        $booleans = $this->booleans->findAll();
//        $booleans = $this->createDataCache('stat.total', []);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getUnlock(): array
    {
        $booleans = $this->booleans->findBy(['locked' => false]);
//        $booleans = $this->createDataCache('stat.unlock', ['locked' => false]);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getLocked(): array
    {
        $booleans = $this->booleans->findBy(['locked' => true]);
//        $booleans = $this->createDataCache('stat.locked', ['locked' => true]);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getGold(): array
    {
        $booleans = $this->booleans->findBy(['locked' => false, 'gold' => true]);
//        $booleans = $this->createDataCache('stat.gold', ['locked' => false, 'gold' => true]);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getToUnlock(): array
    {
        $booleans = $this->booleans->findBy(['locked' => false, 'toUnlock' => true]);
//        $booleans = $this->createDataCache('stat.tounlock', ['locked' => false, 'toUnlock' => true]);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getToUpgrade(): array
    {
        $booleans = $this->booleans->findBy(['locked' => false, 'toUpgrade' => true]);
//        $booleans = $this->createDataCache('stat.toupgrade', ['locked' => false, 'toUpgrade' => true]);
        return self::getReturn($booleans);
    }

    /**
     * @return array<string, int>
     */
    private function getToGold(): array
    {
        $booleans = $this->booleans->findBy(['locked' => true, 'toGold' => true]);
//        $booleans = $this->createDataCache('stat.togold', ['locked' => true, 'toGold' => true]);
        return self::getReturn($booleans);
    }

    /**
     * @param array $booleans
     * @return array<string, int>
     */
    private static function getReturn(array $booleans): array
    {
        /** Init */
        $countD = $countC = $countB = $countA = $countS = 1;
        $return = [];

        /** Toutes les voitures */
        foreach ($booleans as $boolean) {
            switch ($boolean->getGarage()->getSettingClass()->getValue()):
                case 'D':
                    $return['D'] = $countD++;
                    break;
                case 'C':
                    $return['C'] = $countC++;
                    break;
                case 'B':
                    $return['B'] = $countB++;
                    break;
                case 'A':
                    $return['A'] = $countA++;
                    break;
                case 'S':
                    $return['S'] = $countS++;
                    break;
                default:
                    $return      = [];
                    break;
            endswitch;
        }

        /** Default Values */
        if ($return === []) {
            $return['D'] = $return['C'] = $return['B'] = $return['A'] = $return['S'] = 0;
        }

        /** Calcul le Total */
        $return['Total'] = $return['D'] + $return['C'] + $return['B'] + $return['A'] + $return['S'];

        return $return;
    }
}
