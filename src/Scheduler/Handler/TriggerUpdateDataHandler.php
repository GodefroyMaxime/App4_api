<?php 

namespace App\Scheduler\Handler;

use App\Scheduler\Message\TriggerUpdateDataMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsMessageHandler]
class TriggerUpdateDataHandler
{
    public function __construct(#[Autowire('%kernel.project_dir%')] private $dir) {
    }

    public function __invoke(TriggerUpdateDataMessage $message)
    {
        $logsFolder = $this->dir . '/public/logs/'; 
        if (!is_dir($logsFolder)) {
            mkdir($logsFolder, 0777, true);
        }

        $logFilePath = $logsFolder . 'UpdatingDataTaskLogs.txt';
        if (!file_exists($logFilePath)) {
            file_put_contents($logFilePath, '');
        }

        $command = 'php bin/console App:UpdatingData';
        $process = Process::fromShellCommandline($command);
        
        try {
            $process->mustRun();
            
            $successMessage = "[" . date('Y-m-d H:i:s') . "]" . " - Commande exécutée avec succès : " . $process->getOutput() . PHP_EOL;
            file_put_contents($logFilePath, $successMessage, FILE_APPEND);
        } catch (ProcessFailedException $exception) {
            $errorMessage = "[" . date('Y-m-d H:i:s') . "]" . " - Erreur lors de l'exécution de la commande : " . $exception->getMessage() . PHP_EOL;
            file_put_contents($logFilePath, $errorMessage, FILE_APPEND);
        }
    }
}