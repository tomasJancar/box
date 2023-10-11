<?php declare(strict_types = 1);

namespace App\Package;

use App\Product\Product;
use Doctrine\ORM\EntityManager;
use Nette\Utils\Json;

class DatabasePackageCache implements PackageCacheInterface
{
    /**
     * @param Product[] $products
     *
     * @return Packaging|null
     */
    public function findByProducts(EntityManager $entityManager, array $products): ?Packaging
    {
        $productsIds = array_map(
            fn(Product $product) => $product->getId(),
            $products
        );

        ksort($productsIds);
        $cachedItems = $entityManager->getRepository(Cache::class)->findBy(['productsIds' => Json::encode($productsIds)]);

        var_dump($cachedItems);

        if ($cachedItems === []) {
            return null;
        }

        return $cachedItems[0]->getPackaging();
    }


    /**
     * @param Product[] $products
     */
    public function save(EntityManager $entityManager, array $products, Packaging $packaging): void
    {
        $productsIds = array_map(
            fn(Product $product) => $product->getId(),
            $products
        );

        ksort($productsIds);
        $cache = new Cache($packaging, $productsIds);

        $entityManager->persist($cache);
        $entityManager->flush();
    }
}
