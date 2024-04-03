<?php 

namespace App\Scheduler\Handler;

use App\Scheduler\Message\TriggerUpdateDataMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

#[AsMessageHandler]
class TriggerUpdateDataHandler
{
    public function __invoke(TriggerUpdateDataMessage $message)
    {
        $command = 'php bin/console App:UpdatingData';
        $process = Process::fromShellCommandline($command);
        
        try {
            $process->mustRun();
            
            echo 'Commande exécutée avec succès : '.$process->getOutput();
        } catch (ProcessFailedException $exception) {
            echo 'Erreur lors de l\'exécution de la commande : '.$exception->getMessage();
        }
    }
}