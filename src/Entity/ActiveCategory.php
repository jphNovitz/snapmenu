<?php

namespace App\Entity;

use App\Repository\ActiveCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiveCategoryRepository::class)]
class ActiveCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $rowOrder = 5;

    #[ORM\ManyToOne(inversedBy: 'activeCategories')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'activeCategories')]
    private ?Store $store = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRowOrder(): ?int
    {
        return $this->rowOrder;
    }

    public function setRowOrder(?int $rowOrder): static
    {
        $this->rowOrder = $rowOrder;

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

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): static
    {
        $this->store = $store;

        return $this;
    }
}
