<?php declare(strict_types = 1);

namespace App;

use Doctrine\ORM\EntityManager;
use Nette\DI\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

class Application
{
    private EntityManager $entityManager;

    private Container $container;


    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }


    public function run(RequestInterface $request): ResponseInterface
    {
        /** @var RequestHandler $requestHandler */
        $requestHandler = $this->container->getByType(RequestHandler::class);

        $uuid = Uuid::uuid4();
        return $requestHandler->handleRequest(
            $this->entityManager,
            $request->withHeader('X-Request-Id', $uuid->toString())
        );
    }
}
