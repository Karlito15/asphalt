<?php

namespace App\Able;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

trait CommandAble
{
    /**
     * Initialise la commande
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        // ini_set("memory_limit", "-1");
    }

    protected function configure(): void
    {
    }

    /**
     * Lance la commande "Clear"
     *
     * @return void
     */
    public static function clearScreen(): void
    {
        system('clear');
    }

    /**
     * Permet de faire une pause pendant une commande
     *
     * @param int $min - durée minimum en seconde
     * @param int $max - durée maximum en seconde
     * @return void
     * @throws \Exception
     */
    public static function takePause(int $min = 5, int $max = 30): void
    {
        try {
            sleep(random_int($min, $max));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Table Render for CLI Command
     *
     * @param array           $headers example : $headers = [[20, 80], ['lorem', 'ipsum'],] || width of columns | title of columns
     * @param array           $datas
     * @param OutputInterface $output
     * @return Table
     */
    public static function Render(array $headers, array $datas, OutputInterface $output): Table
    {
        list($width, $title) = $headers;

        $table = new Table($output);
        $table->setColumnWidths($width);
        $table->setHeaders($title);
        $table->setStyle('borderless');
        $table->setRows($datas);
        $table->render();

        return $table;
    }

    /**
     * Retourne le chemin vers le dossier des fichiers CSV
     *
     * @return string
     */
    public function getCSVDirectory(): string
    {
        return $this->parameter->get('paths')['csv'];
    }

    /**
     * Retourne l’environnement de l’application
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->parameter->get('kernel.environment');
    }
}
