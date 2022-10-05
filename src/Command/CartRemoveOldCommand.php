<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\OrderRepository;

#[AsCommand(
    name: 'app:cart-remove-old',
    description: 'Remove order older than 90 days',
)]
class CartRemoveOldCommand extends Command
{

    public function __construct(public OrderRepository $orderRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('check', null, InputOption::VALUE_NONE, 'check amount od cart to remove')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('check')) {
            $io-> note('CHECK mode enabled');

            $countOrder = $this->orderRepository->countOrderToRemove();
            $io->success('Amount of cart to remove: '. $countOrder);
        } else {
            $countOrder = $this->orderRepository->deleteOrderToRemove();            
            $io->success('SUCCESS. Removed '. $countOrder .' of orders');
        }
        return 0;
    }
}
