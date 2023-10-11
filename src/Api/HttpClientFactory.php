<?php declare(strict_types = 1);

namespace App\Api;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleLogMiddleware\LogMiddleware;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class HttpClientFactory
{
    public static function create(): Client
    {
        // todo Service
        $logger = new Logger('api');
        $logger->pushHandler(new RotatingFileHandler(__DIR__ . '/../../var/log/api.log'));

        $handlerStack = HandlerStack::create();
        $handlerStack->push(new LogMiddleware($logger));

        // @todo Config
        return new Client([
            'base_uri' => 'https://global-api.3dbinpacking.com',
            'handler' => $handlerStack
        ]);
    }
}
