<?php declare(strict_types = 1);

namespace App\Api;

use App\Package\CantBeStoredInOnePackageException;
use Throwable;
use Exception;

class RequestExceptionFactory
{
    public function create(array $response): Throwable {
        if (count($response['response']['errors']) > 0) {
            return CantBeStoredInOnePackageException::create();
        }

        return new Exception('Unknown error');
    }
}
