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
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;

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
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_AWS_ELB
        );
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
        $schedule->command('sewa:tandai-selesai')->everyFiveMinutes();
    })
    ->create();

app(Kernel::class)->commands([
    ReminderJatuhTempo::class,
]);
