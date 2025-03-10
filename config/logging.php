<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    // 默认的日志通道名称，你可以在.env文件中修改
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    // 所有的日志日志通道配置，外层数组的键名即为日志通道的名称
    'channels' => [
        // stack是默认使用的日志通道
        'stack' => [
            // 这个驱动让你可以将多个日志通道组合成一个来使用
            'driver' => 'daily',
            // stack日志通道是由这些日志通道组合而成的
            'channels' => ['sql','single','daily'],
            // 设置为true后，如果某一通道记录日志出错，日志信息仍然发送到下一个日志通道
            'ignore_exceptions' => false,
        ],

        'sql' => [
            'driver' => 'daily',
            'path' => storage_path().'/logs/sql/sql.log',
            'days' => env('LOG_DAILY_DAYS', 14),
            'tap' => [App\Listeners\QueryListener::class],
        ],

        'single' => [
            // 这个驱动使用单个文件记录日志
            'driver' => 'single',
            // 记录日志的文件
            'path' => storage_path('logs/laravel/laravel.log'),
            // 日志级别，所有可用的日志级别：emergency、alert、 critical、 error、 warning、 notice、 info 和 debug。大于等于这个等级的日志才会被记录。
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',// 这个驱动每天生成一个新的日志文件记录日志
            'path' => storage_path('logs/laravel/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => env('LOG_DAILY_DAYS', 14),// 保留多少天的日志
            'replace_placeholders' => true,
            'process_psr7' => true,
            'tap' => [App\Listeners\RequestLogHandler::class],
        ],

        'slack' => [
            // 这个驱动将日志文件写入你的slack账号中
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            // 这个驱动使用指定的Monolog Handler处理日志
            'driver' => 'monolog',
            'level' => 'debug',
            // 这个就是上面提到的指定的Monolog Handler
            'handler' => SyslogUdpHandler::class,
            // SyslogUdpHandler类构造方法的参数，这个Handler将日志信息记录到远程的syslogd服务器
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            // 使用Monolog的StreamHandler处理日志
            'handler' => StreamHandler::class,
            // 日志格式
            'formatter' => env('LOG_STDERR_FORMATTER'),
            // StreamHandler构造方法的参数，指明输出流
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            // 这个驱动使用php的syslog函数记录日志
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            // 这个驱动使用php的error_log函数记录日志
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            // 黑洞模式，相当于不记录日志
            'handler' => NullHandler::class,
        ],

        // 获取或创建上面的日志通道失败时，回退使用的日志通道，记录失败的原因及原来要记录的日志信息，path指定日志文件路径
        'emergency' => [
            'path' => storage_path('logs/laravel/laravel.log'),
        ],
    ],

];