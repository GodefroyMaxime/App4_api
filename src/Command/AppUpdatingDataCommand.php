<?php

namespace App\Command;

use App\Service\ApiToBDDService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Input\InputArgument;
// use Symfony\Component\Console\Input\InputOption;
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

        // $progressBar = new ProgressBar($output, 3);

        // $progressBar->start();

        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        try {
            $io->newLine(1);
                
            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - Démmarage de la mise à jour de la liste des employés.');
            $employeeList = $this->api->updateEmployeeList();
            // $progressBar->advance();
            if (!empty($employeeList['create'])) {
                foreach ($employeeList['create'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - Le matricule ' .  $key . ' a été ajouté.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($employeeList['create']) . ' matricules ont été ajoutés.');
            }
            if (!empty($employeeList['update'])) {
                foreach ($employeeList['update'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - Le matricule ' .  $key . ' a été mis à jour.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($employeeList['update']) . ' matricules ont été mis à jour.');
            }
            if (!empty($employeeList['history'])) {
                foreach ($employeeList['history'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - Le matricule ' .  $key . ' a été archivé.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($employeeList['history']) . ' matricules ont été archivés.');
            }
            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - La liste des employés a été mise à jour avec succès.');


            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - Démmarage de la mise à jour de la liste des organisations supérieures.');
            $supOrgaList = $this->api->updateSupOrgaList();
            // $progressBar->advance();
            if (!empty($supOrgaList['create'])) {
                foreach ($supOrgaList['create'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'organisation supérieure ' .  $key . ' a été ajouté.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($supOrgaList['create']) . ' organisations supérieures ont été ajoutés.');
            }
            if (!empty($supOrgaList['update'])) {
                foreach ($supOrgaList['update'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'organisation supérieure ' .  $key . ' a été mis à jour.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($supOrgaList['update']) . ' organisations supérieures ont été mis à jour.');
            }
            if (!empty($supOrgaList['history'])) {
                foreach ($supOrgaList['history'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'organisation supérieure ' .  $key . ' a été archivé.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($supOrgaList['history']) . ' organisations supérieures ont été archivés.');
            }
            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - La liste des organisations supérieures a été mise à jour avec succès.');
        
            
            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - Démmarage de la mise à jour de la liste des anciennetés.');
            $senioritiesList = $this->api->updateSenioritiesList();
            // $progressBar->advance();            
            if (!empty($senioritiesList['create'])) {
                foreach ($senioritiesList['create'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'ancinneté du matricule ' .  $key . ' a été ajouté.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($senioritiesList['create']) . ' ancinnetés ont été ajoutés.');
            }
            if (!empty($senioritiesList['update'])) {
                foreach ($senioritiesList['update'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'ancinneté du matricule ' .  $key . ' a été mis à jour.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($senioritiesList['update']) . ' ancinnetés ont été mis à jour.');
            }
            if (!empty($senioritiesList['history'])) {
                foreach ($senioritiesList['history'] as $key => $value) {
                    $io->writeln('[' . $value . ']' . ' - L\'ancinneté du matricule ' .  $key . ' a été archivé.');
                }
                $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - ' .  count($senioritiesList['history']) . ' ancinnetés ont été archivés.');
            }
            $io->writeln('[' . date('Y-m-d H:i:s') . ']' . ' - La liste des anciennetés a été mise à jour avec succès.');

            // $progressBar->finish();
        } catch (\Exception $e) {
            $io->error(sprintf('[' . date('Y-m-d H:i:s') . ']' . ' - Une erreur est survenue pendant la mise à jour des données : %s', $e->getMessage()));
            // $progressBar->finish();
            return Command::FAILURE;
        }
    
        // En cas de succès global de toutes les opérations
        $io->success('[' . date('Y-m-d H:i:s') . ']' . ' - Les données de l\'application ont été mises à jour avec succès depuis les services web.');
    
        return Command::SUCCESS;
    }
}
