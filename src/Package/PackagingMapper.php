<?php declare(strict_types = 1);

namespace App\Package;

class PackagingMapper
{
    public function map(Packaging $packaging): array
    {
        return [
            'id' => $packaging->getId(),
            'w' => $packaging->getWidth(),
            'h' => $packaging->getHeight(),
            'd' => $packaging->getLength(),
            'max_wg' => $packaging->getMaxWeight(),
        ];
    }


    /**
     * @param Packaging[] $packaging
     */
    public function mapMultiple(array $packaging): array
    {
        return array_map(
            function (Packaging $packaging) {
                return $this->map($packaging);
            },
            $packaging
        );
    }
}
