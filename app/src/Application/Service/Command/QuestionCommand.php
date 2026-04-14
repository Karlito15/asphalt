<?php

declare(strict_types=1);

namespace App\Application\Service\Command;

use Symfony\Component\Console\Exception\MissingInputException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

trait QuestionCommand
{
    /**
     * @param string|null $choice
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string|null
     */
    public static function Question(string|null $choice, InputInterface $input, OutputInterface $output): string|null
    {
        if (is_null($choice)) {
            $helper   = new QuestionHelper();
            $question = new ChoiceQuestion('Do you want to export or import datas ?', [
                'export',
                'import'
            ],
                'export'
            );
            $question->setAutocompleterValues(['import', 'import']);
            $question->setTimeout(seconds: 5);

            try {
                return $helper->ask($input, $output, $question);
            } catch (MissingInputException $exception) {
                $output->writeln('No input received within timeout period.');
                $output->writeln(__FILE__);
                throw new MissingInputException($exception->getMessage());
            }
        }

        return $choice;
    }
}
