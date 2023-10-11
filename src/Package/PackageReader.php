<?php declare(strict_types = 1);

namespace App\Package;

use App\Api\Client;
use App\Api\RequestBuilder;
use App\Product\Product;
use App\Product\ProductMapper;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class PackageReader
{
    private Client $client;

    private ProductMapper $productMapper;

    private PackagingMapper $packageMapper;

    private PackageCacheInterface $packageCache;

    private RequestBuilder $requestBuilder;


    /**
     * @param Client $client
     */
    public function __construct(
        Client $client,
        RequestBuilder $requestBuilder,
        ProductMapper $productMapper,
        PackagingMapper $packageMapper,
        PackageCacheInterface $packageCache
    ) {
        $this->client = $client;
        $this->productMapper = $productMapper;
        $this->packageMapper = $packageMapper;
        $this->packageCache = $packageCache;
        $this->requestBuilder = $requestBuilder;
    }


    /**
     * @param Product[] $products
     * @param Packaging[] $packaging
     */
    public function tryFindPackage(EntityManager $entityManager, array $products, array $packaging): ?Packaging
    {
        $cachedPackage = $this->packageCache->findByProducts($entityManager,$products);
        if ($cachedPackage !== null) {
            return $cachedPackage;
        }
        $responseBody = $this->tryCallApi($products, $packaging);

        if (isset($responseBody['response']['bins_packed'][0]['bin_data'])) {
            $id = $responseBody['response']['bins_packed'][0]['bin_data']['id'];

            $this->packageCache->save($entityManager, $products, $packaging[$id]);

            return $packaging[$id];
        }

        return null;
    }


    /**
     * @param Product[] $products
     * @param Packaging[] $packaging
     *
     * @todo better naming
     *
     */
    private function tryCallApi(array $products, array $packaging): array
    {
        $requestBody = [
            'items' => $this->productMapper->mapMultiple($products),
            'bins' => $this->packageMapper->mapMultiple($packaging),
        ];

        $request = $this->requestBuilder->createRequest('POST', '/packer/packIntoMany', $requestBody);

        try {
            return $this->client->getArrayResponse($request);
        } catch (RequestException|ClientException  $e) {
            // todo log
            return [];
        }
    }
}
