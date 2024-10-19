<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
#[Vich\Uploadable]
class Store implements \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $vatNumber = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'stores', fileNameProperty: 'logoName', size: 'logoSize')]
    private ?File $logoFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $logoName = null;


    #[ORM\Column(nullable: true)]
    private ?int $logoSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;



    #[ORM\Column(length: 100, nullable: true)]
    private ?string $streetName = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $houseNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $postCode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\OneToOne(inversedBy: 'store', cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: ActiveCategory::class)]
    private Collection $activeCategories;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Product::class)]
    private Collection $products;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, OpeningHours>
     */
    #[ORM\OneToMany(mappedBy: 'store', targetEntity: OpeningHours::class, orphanRemoval: true)]
    private Collection $openingHours;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Message::class)]
    private Collection $messages;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->activeCategories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->openingHours = new ArrayCollection();
        $this->messages = new ArrayCollection();
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): static
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): static
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): static
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setOwner($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getOwner() === $this) {
                $category->setOwner(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, ActiveCategory>
     */
    public function getActiveCategories(): Collection
    {
        return $this->activeCategories;
    }

    public function addActiveCategory(ActiveCategory $activeCategory): static
    {
        if (!$this->activeCategories->contains($activeCategory)) {
            $this->activeCategories->add($activeCategory);
            $activeCategory->setStore($this);
        }

        return $this;
    }

    public function removeActiveCategory(ActiveCategory $activeCategory): static
    {
        if ($this->activeCategories->removeElement($activeCategory)) {
            // set the owning side to null (unless already changed)
            if ($activeCategory->getStore() === $this) {
                $activeCategory->setStore(null);
            }
        }

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
            $product->setOwner($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getOwner() === $this) {
                $product->setOwner(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, OpeningHours>
     */
    public function getOpeningHours(): Collection
    {
        return $this->openingHours;
    }

    public function addOpeningHour(OpeningHours $openingHour): static
    {
        if (!$this->openingHours->contains($openingHour)) {
            $this->openingHours->add($openingHour);
            $openingHour->setStore($this);
        }

        return $this;
    }

    public function removeOpeningHour(OpeningHours $openingHour): static
    {
        if ($this->openingHours->removeElement($openingHour)) {
            // set the owning side to null (unless already changed)
            if ($openingHour->getStore() === $this) {
                $openingHour->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogoName(?string $logoName): void
    {
        $this->logoName = $logoName;
    }

    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public function setLogoSize(?int $logoSize): void
    {
        $this->logoSize = $logoSize;
    }

    public function getLogoSize(): ?int
    {
        return $this->logoSize;
    }

    public function serialize()
    {
        return [];
    }

    public function unserialize(string $data)
    {
        return [];
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setOwner($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getOwner() === $this) {
                $message->setOwner(null);
            }
        }

        return $this;
    }
}
