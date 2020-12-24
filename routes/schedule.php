<?php

/** @var \Illuminate\Console\Scheduling\Schedule $schedule */

$schedule->command('telescope:prune --hours=48')->daily();

$isCommandRunning = function ($command) {
    exec('ps aux -ww', $process_status);

    $result = array_filter($process_status, function ($var) use ($command) {
        return strpos($var, $command);
    });

    return count($result) > 0;
};

$command = 'queue:work --tries=3 --queue=high,medium,low,default';
if (! $isCommandRunning($command)) {
    $schedule->command($command)
        ->everyMinute();
}
