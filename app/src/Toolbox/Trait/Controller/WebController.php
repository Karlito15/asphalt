<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Controller;

use App\Toolbox\System\Path;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

trait WebController
{
    public function __construct(
        private readonly KernelInterface $kernel,
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
        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }

    public function generateGarageList(): void
    {
        ### Launch Command To Generate Garage List YAML
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput([
            'command' => 'asphalt:yaml:list:garage', // Nom de votre commande
            // Arguments optionnels
            // 'fooArgument' => 'barValue',
            // Options
            // '--bar' => 'fooValue',
            // '--baz' => true,
        ]);
        $output = new BufferedOutput();
        try {
            $application->run($input, $output);
            $this->addFlash('success', 'YAML Generated Successfully');
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @param bool $bool
     * @return void
     */
    public function return404(bool $bool): void
    {
        if (!$bool) {
            throw $this->createNotFoundException($this->translator->trans('error.class'));
        }
    }

    /**
     * @return string
     */
    public function ExtractionFolder(): string
    {
        return Path::canonicalize(
            $this->getParameter('folders.yaml') . DIRECTORY_SEPARATOR .
            self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /** STATIC METHODS */

    /**
     * @param string|null $level1
     * @param string|null $level2
     * @return null[]|string[]
     */
    public static function Breadcrump(null|string $home, null|string $page) :array
    {
        return ['home' => $home, 'page' => $page];
    }

    /**
     * Retourne les liens vers la page index, la page création & de suppression
     *
     * @return array
     */
    public static function LinksPage(): array
    {
        return [
            'index'  => self::$index,
            'create' => self::$create,
            'delete' => self::$delete,
        ];
    }

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
