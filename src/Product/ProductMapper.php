<?php declare(strict_types = 1);

namespace App\Product;

class ProductMapper
{
    public function map(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'w' => $product->getWidth(),
            'h' => $product->getHeight(),
            'd' => $product->getLength(),
            'wg' => $product->getWeight(),
            'vr' => true,
            'q' => 1,
        ];
    }


    /**
     * @param Product[] $products
     */
    public function mapMultiple(array $products): array
    {
        $mappedProducts = [];
        foreach ($products as $product) {
            if (isset($mappedProducts[$product->getId()])) {
                $mappedProducts[$product->getId()]['q']++;
                continue;
            }

            $mappedProduct = $this->map($product);
            $mappedProducts[$product->getId()] = $mappedProduct;
        }

        return $mappedProducts;
    }
}
