<?php declare(strict_types = 1);

namespace App\Package;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Json;

#[ORM\Entity]
class Cache
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Packaging::class)]
    #[ORM\JoinColumn(name: 'package_id', referencedColumnName: 'id')]
    private Packaging $packaging;

    #[ORM\Column(type: Types::STRING)]
    private string $productsIds;


    public function __construct(Packaging $packaging, array $productsIds)
    {
        $this->packaging = $packaging;
        $this->productsIds = Json::encode($productsIds);
    }


    public function getPackaging(): Packaging
    {
        return $this->packaging;
    }


    public function getProductsIds(): array
    {
        return Json::decode($this->productsIds, true);
    }
}
