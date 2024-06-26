<?php

namespace App\Scheduler;

use App\Scheduler\Message\TriggerUpdateDataMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Cron\CronExpression; 
use Symfony\Component\Scheduler\Trigger\CronExpressionTrigger;

#[AsSchedule]
class UpdateDataTask implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        $schedule = new Schedule();
        $cronExpression = new CronExpression('0 */12 * * *');

        $schedule->add(
            RecurringMessage::trigger(
                new CronExpressionTrigger($cronExpression),
                new TriggerUpdateDataMessage()
            )
        );

        return $schedule;
    }
}
