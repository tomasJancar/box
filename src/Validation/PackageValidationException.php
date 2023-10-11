<?php declare(strict_types = 1);

namespace App\Validation;

use Exception;

class PackageValidationException extends Exception
{
    // @todo split into more specific exceptions
    public static function createFromInvalidPackage(): self {
        return new self('Invalid package');
    }
}
