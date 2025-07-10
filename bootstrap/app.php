<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Console\Kernel;
use App\Console\Commands\ReminderJatuhTempo;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'user.auth' => UserMiddleware::class,
            'admin.auth' => AdminMiddleware::class,
        ]);
    })
    ->withProviders([
        App\Providers\ViewServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, $request) {
            $guard = $e->guards()[0] ?? null;

            if ($guard === 'admin') {
                return redirect()->route('admin.login');
            }

            return redirect()->route('login');
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('reminder:jatuh-tempo')->dailyAt('07:00'); // atau '08:00' sesuai kebutuhan
        $schedule->command('sewa:tandai-selesai')->daily();
    })
    ->create();

app(Kernel::class)->commands([
    ReminderJatuhTempo::class,
]);
