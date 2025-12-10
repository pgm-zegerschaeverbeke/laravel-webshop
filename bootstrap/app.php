<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withSchedule(function (Schedule $schedule): void {
        // nu in bootstrap stuurt de newsletter mail elke donderdag om 13:00
        $schedule->command('newsletter:send')
            ->weeklyOn(4, '13:00')
            ->timezone('Europe/Brussels');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
