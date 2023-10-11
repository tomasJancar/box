<?php declare(strict_types = 1);

namespace App\Product;

class ProductFactory
{
    // service?
    /**
     * @param array<string, float|int> $packageRawData
     */
    public static function create(array $packageRawData): Product
    {
        return new Product(
            $packageRawData[ProductApiFields::ID],
            $packageRawData[ProductApiFields::WIDTH],
            $packageRawData[ProductApiFields::HEIGHT],
            $packageRawData[ProductApiFields::LENGTH],
            $packageRawData[ProductApiFields::WEIGHT],
        );
    }
}
