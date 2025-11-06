<?php

namespace App\Controller\Front\Page\Filter;

use App\Repository\GarageAppRepository;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TagController extends AbstractController
{
    use WebTrait;

    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}
}
