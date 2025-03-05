<?php
namespace App\Listeners;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;

class RequestLogHandler
{
    /**
     * 自定义给定的日志记录器实例。
     */
    public function __invoke(Logger $logger): void
    {

        foreach ($logger->getHandlers() as $handler) {
            $url = request()->fullUrl();
            $method = request()->method();
            $parameters = request()->all();

            $formatted = "{$method} {$url} with parameters: " . json_encode($parameters)."\n";

            $formatter = new LineFormatter(
                '[%datetime%] %channel%.%level_name%: '.$formatted.' %message% %context% %extra%'."\n"
            );
            $formatter->includeStacktraces();
            $handler->setFormatter($formatter);
        }
    }
}