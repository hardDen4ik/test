<?php

namespace App\Entity;

use App\Repository\ParameterProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterProductRepository::class)]
class ParameterProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Parameter::class, inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parameter $parameter = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParameter(): ?Parameter
    {
        return $this->parameter;
    }

    public function setParameter(?Parameter $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProductId(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
