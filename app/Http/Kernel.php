<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Barryvdh\Cors\HandleCors::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //Passport
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],

        'admin' => [
            'admin.auth',
            'permission:view-backend',
            'timeout'
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'timeout' => \App\Http\Middleware\SessionTimeout::class,

        /**
         * 角色权限
         */
        'role' => \App\Http\Middleware\RouteNeedsRole::class,
        'permission' => \App\Http\Middleware\RouteNeedsPermission::class,
        /**
         * 自定义后台admin登录
         */
        'admin.auth' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'passport' => \App\Http\Middleware\PassportDingo::class,
        'authOrNot' => \App\Http\Middleware\PassportAuthOrNot::class,
        'cacheable' => \Spatie\Varnish\Middleware\CacheWithVarnish::class,
    ];
}
