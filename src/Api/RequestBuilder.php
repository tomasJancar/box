<?php declare(strict_types = 1);

namespace App\Api;

use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;
use Psr\Http\Message\RequestInterface;

class RequestBuilder
{
    private string $userName;

    private string $apiKey;


    public function __construct(string $userName, string $apiKey)
    {
        $this->userName = $userName;
        $this->apiKey = $apiKey;
    }


    /**
     * @param mixed[] $requestBody
     */
    public function createRequest(string $method, string $uri, array $requestBody): RequestInterface
    {
        $requestBody['username'] = $this->userName;
        $requestBody['api_key'] = $this->apiKey;

        return new Request(
            'POST',
            $uri,
            [],
            Json::encode($requestBody)
        );
    }
}
