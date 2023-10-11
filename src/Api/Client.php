<?php declare(strict_types = 1);

namespace App\Api;

use GuzzleHttp\Client as HttpClient;
use Nette\Utils\Json;
use Psr\Http\Message\RequestInterface;

class Client
{
    private HttpClient $httpClient;

    private RequestExceptionFactory $requestExceptionFactory;


    public function __construct(HttpClient $httpClient, RequestExceptionFactory $requestExceptionFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestExceptionFactory = $requestExceptionFactory;
    }


    public function getArrayResponse(RequestInterface $request): array
    {
        $response = $this->httpClient->send($request);
        $response = Json::decode((string)$response->getBody(), true);

        if (count($response['response']['errors']) > 0) {
            throw $this->requestExceptionFactory->create($response);
        }

        return $response;
    }
}
