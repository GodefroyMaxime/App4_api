<?php

namespace App\Command;

use App\Service\ApiToBDDService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'App:UpdatingData',
    description: 'Updates the application data by fetching the latest information from various web services.',
)]
class AppUpdatingDataCommand extends Command
{
    public function __construct(private ApiToBDDService $api)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        try {
            $this->api->updateEmployeeList();
            $io->success('La liste des employés a été mise à jour avec succès.');
    
            $this->api->updateSupOrgaList();
            $io->success('La liste des organisations supérieur a été mise à jour avec succès.');
    
            $this->api->updateSenioritiesList();
            $io->success('La liste des anciennetés a été mise à jour avec succès.');
    
            $io->note('Toutes les mises à jour nécessaires ont été effectuées.');
        } catch (\Exception $e) {
            $io->error(sprintf('Une erreur est survenue pendant la mise à jour des données : %s', $e->getMessage()));
    
            return Command::FAILURE;
        }
    
        // En cas de succès global de toutes les opérations
        $io->success('Les données de l\'application ont été mises à jour avec succès depuis les services web.');
    
        return Command::SUCCESS;
    }
}
