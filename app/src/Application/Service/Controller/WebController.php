<?php

declare(strict_types=1);

namespace App\Application\Service\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

trait WebController
{
    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly EntityManagerInterface $manager,
        private readonly ParameterBagInterface $parameter,
        private readonly TranslatorInterface $translator,
    )
    {}

    /**
     * Redirection vers la page index
     *
     * @return RedirectResponse
     */
    public function redirectToIndex(): RedirectResponse
    {
        return $this->redirectToRoute(self::$crud['index'], [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Page 404
     *
     * @param bool $bool
     * @return void
     */
    public function return404(bool $bool): void
    {
        if (!$bool) {
            throw $this->createNotFoundException($this->translator->trans('error.class'));
        }
    }

//    /**
//     * Régénère les fichiers YAML pour les pages index
//     *
//     * @return void
//     */
//    public function generateGarageList(): void
//    {
//        ### Launch Command To Generate Garage List YAML
//        $application = new Application($this->kernel);
//        $application->setAutoExit(false);
//        $input = new ArrayInput([
//            'command' => 'asphalt:yaml:list:garage', // Nom de votre commande
//            // Arguments optionnels
//            // 'fooArgument' => 'barValue',
//            // Options
//            // '--bar' => 'fooValue',
//            // '--baz' => true,
//        ]);
//        $output = new BufferedOutput();
//        try {
//            $application->run($input, $output);
//            $this->addFlash('success', 'YAML Generated Successfully');
//        } catch (\Exception $e) {
//            throw new \RuntimeException($e->getMessage());
//        }
//    }

//    /**
//     * @return string
//     */
//    public function ExtractionFolder(): string
//    {
//        // $filepath = $this->getParameter('folders.yaml') . DIRECTORY_SEPARATOR . self::$folder . DIRECTORY_SEPARATOR . self::$file;
//        $filepath = $this->getParameter('folders.yaml') . DIRECTORY_SEPARATOR;
//
//        if (Folder::isExists($filepath)) {
//            return Folder::canonicalize($filepath);
//        }
//
//        throw $this->createNotFoundException($this->translator->trans('error.file'));
//    }

    /** STATIC METHODS */

    /**
     * Retourne la lettre de la Class en minuscule
     *
     * @param string $letter
     * @return string
     */
    public static function Letter(string $letter): string
    {
        return strtoupper($letter);
    }

    /**
     * @param string $letter
     * @return bool
     */
    public static function ControlLetter(string $letter): bool
    {
        return match ($letter) {
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => true,
            'S' => true,
            default => false,
        };
    }
}
