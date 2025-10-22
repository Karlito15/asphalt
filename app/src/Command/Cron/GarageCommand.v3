<?php

namespace App\Command\Cron;

use Exception;
use App\Able\CommandAble;
use App\Event\BooleanGarageEvent;
use App\Repository\AppGarageRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:garage',
    description: 'Éxamine les états de chaque voiture du garage',
    aliases: ['a:c:g', 'asphalt-cron-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly EventDispatcherInterface $dispatcher
    )
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io = new SymfonyStyle($input, $output);

        foreach ($this->garage->findAll() as $garage) {
            // Events
            try {
                $this->dispatcher->dispatch(new BooleanGarageEvent($garage));
                $this->garage->save($garage, true);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        // Conclusion
        $io->success($this->getDescription());

        return Command::SUCCESS;
    }
}
