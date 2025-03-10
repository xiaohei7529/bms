<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

require_once __DIR__.'/../app/Helpers/functions.php';

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

//添加了sql语句监听输出
// if(env('APP_DEBUG') || !empty($_REQUEST['_debug']) ) $app->register(App\Providers\EventServiceProvider::class);

// 设置session别名
$app->alias('session', 'Illuminate\Session\SessionManager');


$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

/**
 * laravel 日志 按照日期保存
 */
// $app->configureMonologUsing(function(Monolog\Logger $monoLog) use ($app){
//     return $monoLog->pushHandler(
//         (new \Monolog\Handler\RotatingFileHandler($app->storagePath().'/logs/laravel/laravel.log'))
//             ->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true))
//     );
// });

return $app;
