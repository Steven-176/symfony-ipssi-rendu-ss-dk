<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartProductRepository::class)]
class CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartProducts')]
    private ?Product $products = null;

    #[ORM\ManyToOne(inversedBy: 'cartProducts')]
    private ?Cart $carts = null;

    #[ORM\Column(nullable: true)]
    private ?int $product_quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $size = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $size_top = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getCarts(): ?Cart
    {
        return $this->carts;
    }

    public function setCarts(?Cart $carts): self
    {
        $this->carts = $carts;

        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->product_quantity;
    }

    public function setProductQuantity(?int $product_quantity): self
    {
        $this->product_quantity = $product_quantity;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSizeTop(): ?string
    {
        return $this->size_top;
    }

    public function setSizeTop(?string $size_top): self
    {
        $this->size_top = $size_top;

        return $this;
    }
}
