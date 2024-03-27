<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;


    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryInStore::class)]
    private Collection $categoryInStores;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categoryInStores = new ArrayCollection();
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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, CategoryInStore>
     */
    public function getCategoryInStores(): Collection
    {
        return $this->categoryInStores;
    }

    public function addCategoryInStore(CategoryInStore $categoryInStore): static
    {
        if (!$this->categoryInStores->contains($categoryInStore)) {
            $this->categoryInStores->add($categoryInStore);
            $categoryInStore->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryInStore(CategoryInStore $categoryInStore): static
    {
        if ($this->categoryInStores->removeElement($categoryInStore)) {
            // set the owning side to null (unless already changed)
            if ($categoryInStore->getCategory() === $this) {
                $categoryInStore->setCategory(null);
            }
        }

        return $this;
    }


}
