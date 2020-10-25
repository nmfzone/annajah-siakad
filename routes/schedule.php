<?php

/** @var \Illuminate\Console\Scheduling\Schedule $schedule */

$schedule->command('telescope:prune --hours=48')->daily();
