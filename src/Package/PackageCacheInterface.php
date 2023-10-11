<?php declare(strict_types = 1);

namespace App\Package;

use App\Product\Product;
use Doctrine\ORM\EntityManager;

interface PackageCacheInterface
{
    /**
     * @param Product[] $products
     *
     * @return Packaging|null
     */
    public function findByProducts(EntityManager $entityManager, array $products): ?Packaging;


    /**
     * @param Product[] $products
     */
    public function save(EntityManager $entityManager, array $products, Packaging $packaging): void;
}
