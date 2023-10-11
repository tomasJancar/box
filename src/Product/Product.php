<?php declare(strict_types = 1);

namespace App\Product;

class Product
{
    private int $id;

    private float $width;

    private float $height;

    private float $length;

    private float $weight;


    /**
     * @param int $id
     * @param float $width
     * @param float $height
     * @param float $length
     * @param float $weight
     */
    public function __construct(int $id, float $width, float $height, float $length, float $weight)
    {
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->weight = $weight;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getWidth(): float
    {
        return $this->width;
    }


    public function getHeight(): float
    {
        return $this->height;
    }


    public function getLength(): float
    {
        return $this->length;
    }


    public function getWeight(): float
    {
        return $this->weight;
    }
}

