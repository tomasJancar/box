<?php declare(strict_types = 1);

namespace App;

use App\Api\RequestApiFields;
use App\Package\CantBeStoredInOnePackageException;
use App\Package\PackageFallbackProcessor;
use App\Package\PackageReader;
use App\Package\Packaging;
use App\Product\ProductFactory;
use App\Validation\PackageValidator;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use Nette\Utils\Json;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestHandler
{
    private PackageValidator $packageValidator;

    private PackageReader $packageReader;

    private PackageFallbackProcessor $packageFallbackProcessor;


    public function __construct(PackageValidator $packageValidator, PackageReader $packageReader, PackageFallbackProcessor $packageFallbackProcessor)
    {
        $this->packageValidator = $packageValidator;
        $this->packageReader = $packageReader;
        $this->packageFallbackProcessor = $packageFallbackProcessor;
    }


    public function handleRequest(EntityManager $entityManager, RequestInterface $request): ResponseInterface
    {
        // @todo: sestrelit celou aplikaci, pokud je jeden balicek nevalidni?

        $this->packageValidator->validate($request);
        $decodedResponse = Json::decode((string)$request->getBody(), true);

        $products = array_map(function (array $rawProduct) {
            return ProductFactory::create($rawProduct);
        }, $decodedResponse[RequestApiFields::PRODUCTS]);

        $packages = $entityManager->getRepository(Packaging::class)->findAll();

        try {
            $foundPackage = $this->packageReader->tryFindPackage($entityManager, $products, $packages);
        } catch (CantBeStoredInOnePackageException $exception) {
            return new Response(
                400,
                ['X-Request-Id' => $request->getHeader('X-Request-Id')],
                Json::encode(['error' => $exception->getMessage()]),
            );
        }

        if ($foundPackage === null) {
            $foundPackage = $this->packageFallbackProcessor->process($products, $packages);
            // todo - log
        }

        return new Response(
            200,
            ['X-Request-Id' => $request->getHeader('X-Request-Id')],
            Json::encode(
                [
                    'width' => $foundPackage->getWidth(),
                    'height' => $foundPackage->getHeight(),
                    'length' => $foundPackage->getLength(),
                ]
            ),
        );
    }
}
