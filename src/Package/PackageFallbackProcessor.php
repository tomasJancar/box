<?php declare(strict_types = 1);

namespace App\Package;

use App\Product\Product;

class PackageFallbackProcessor
{
    /**
     * @param Product[] $products
     * @param Packaging[] $packages
     *
     * @return Packaging
     */
    public function process(array $products, array $packages): Packaging
    {
        // todo logic
        //

        return $packages[0];
    }
}
