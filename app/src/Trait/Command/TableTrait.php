<?php

declare(strict_types=1);

namespace App\Trait\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

trait TableTrait
{
    /**
     * Provides helpers to display a table.
     * $headers = [
     *     [20, 40, 40],                // $headers
     *     ['lorem', 'ipsum', 'ipsum'], // $datas
     * ];
     *
     * @param array<array>    $headers
     * @param array<array>    $content
     * @param OutputInterface $output
     * @return Table
     */
    public static function table(array $headers, array $content, OutputInterface $output): Table
    {
        list($width, $title)  = $headers;
        $nb                   = count($content);
        $table                = new Table($output);
        $table->setColumnWidths($width);
        $table->setHeaders($title);
        $table->setStyle('borderless');
        switch ($nb) :
            case 1:
                $table->setRows([$content]);
                break;
            case ($nb > 1):
                $table->setRows($content);
                break;
        endswitch;
        $table->render();

        return $table;
    }
}
