<?php declare(strict_types = 1);

namespace App\Package;

use Exception;

class CantBeStoredInOnePackageException extends Exception
{
    public static function create(): self
    {
        return new self('Products can not be stored in one package');
    }
}
