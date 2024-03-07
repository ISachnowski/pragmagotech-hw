<?php

declare(strict_types=1);

namespace App\Loan\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Loan\Application\Service\FeeService;
use App\Loan\Domain\Model\Entity\Loan;

#[AsCommand(
    name: 'app:calculate-fee',
    hidden: false
)]
final class CalculateFeeCommand extends Command
{
    private $feeService;

    public function __construct(FeeService $feeService)
    {
        parent::__construct();

        $this->feeService = $feeService;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Calculate fee by term and loan value')
                ->addArgument('term', InputArgument::REQUIRED, 'Term (12/24)')
                ->addArgument('amount', InputArgument::REQUIRED, 'Amount')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Term: '.$input->getArgument("term"),
            '===================================',
            'Loan: '.$input->getArgument("amount"),
            '===================================',
        ]);

        $fee = $this->feeService->calculate(new Loan((int) $input->getArgument("term"), (float) $input->getArgument("amount")));
        $output->writeln("Fee: ".$fee);

        return Command::SUCCESS;
    }
}