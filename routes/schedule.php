<?php

/** @var \Illuminate\Console\Scheduling\Schedule $schedule */

$schedule->command('telescope:prune --hours=168')->daily();

$isCommandRunning = function ($command) {
    $cmd = \Symfony\Component\Process\Process::fromShellCommandline('ps aux -ww');
    $cmd->run();

    $output = explode("\n", $cmd->getOutput());

    $result = array_filter($output, function ($var) use ($command) {
        return strpos($var, $command);
    });

    return count($result) > 0;
};

$command = 'queue:work --tries=3 --queue=high,medium,low,default';
if (! $isCommandRunning($command)) {
    $schedule->command($command)
        ->everyMinute();
}
