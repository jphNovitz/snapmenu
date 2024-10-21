<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;


    /**
     * @var Collection<int, Allergen>
     */
    #[ORM\ManyToMany(targetEntity: Allergen::class, inversedBy: 'products')]
    private Collection $allergens;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
    }


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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Allergen>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergen $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(Allergen $allergen): static
    {
        $this->allergens->removeElement($allergen);

        return $this;
    }
}
