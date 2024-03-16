<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 125)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ingredients = null;

    #[ORM\Column(length: 5)]
    private ?string $priceHome = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $priceAway = null;

    #[ORM\Column]
    private ?bool $veggie = false;

    #[ORM\Column]
    private ?bool $halal = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $Description): static
    {
        $this->description = $Description;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(?string $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getPriceHome(): ?string
    {
        return $this->priceHome;
    }

    public function setPriceHome(string $priceHome): static
    {
        $this->priceHome = $priceHome;

        return $this;
    }

    public function getPriceAway(): ?string
    {
        return $this->priceAway;
    }

    public function setPriceAway(?string $priceAway): static
    {
        $this->priceAway = $priceAway;

        return $this;
    }

    public function isVeggie(): ?bool
    {
        return $this->veggie;
    }

    public function setVeggie(bool $veggie): static
    {
        $this->veggie = $veggie;

        return $this;
    }

    public function isHalal(): ?bool
    {
        return $this->halal;
    }

    public function setHalal(bool $halal): static
    {
        $this->halal = $halal;

        return $this;
    }
}
