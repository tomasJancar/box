<?php declare(strict_types = 1);

namespace App\Validation;

use Psr\Http\Message\RequestInterface;

class PackageValidator
{
    /**
     * Radeji bych zde videl kolekci validatoru, ktere budou validovat jednotlive polozky
     * A Tato sluzba by mela byt middleware
     */
    public function validate(RequestInterface $request): void
    {
        $body = (string)$request->getBody();
        $package = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new PackageValidationException('Invalid JSON');
        }
        if (!isset($package['products'])) {
            throw new PackageValidationException('Missing root filed products');
        }
        if (!is_array($package['products'])) {
            throw new PackageValidationException('Products must be an array');
        }
        foreach ($package['products'] as $product) {
            if (!isset($product['id'])) {
                throw new PackageValidationException('Missing field id');
            }
            if (!isset($product['width'])) {
                throw new PackageValidationException('Missing field width');
            }
            if (!isset($product['height'])) {
                throw new PackageValidationException('Missing field height');
            }
            if (!isset($product['length'])) {
                throw new PackageValidationException('Missing field length');
            }
            if (!isset($product['weight'])) {
                throw new PackageValidationException('Missing field weight');
            }
        }
    }
}
