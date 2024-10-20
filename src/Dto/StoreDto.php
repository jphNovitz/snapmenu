<?php

namespace App\Dto;

use App\Entity\Product;
use App\Entity\OpeningHours;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

class StoreDto
{

    #[Vich\UploadableField(mapping: 'stores', fileNameProperty: 'logoName', size: 'logoSize')]
    private ?File $logoFile = null;

    private array $products = [];
    /** @var array<int, OpeningHours> */
    private array $openingHours = [];

    public function __construct(
        private ?int               $id = null,
        private ?string            $name = null,
        private ?string            $vatNumber = null,
        private ?string            $phoneNumber = null,
        private ?string            $description = null,
        private ?string            $logoName = null,


        private ?int               $logoSize = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null,
        private ?string            $streetName = null,
        private ?string            $houseNumber = null,
        private ?string            $postCode = null,
        private ?string            $city = null,
        private ?string            $email = null,
        private ?string            $slug = null

    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

// Validation method
    public function validate(): bool
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        if ($this->phoneNumber && !preg_match('/^[0-9+\-\s()]*$/', $this->phoneNumber)) {
            throw new InvalidArgumentException('Invalid phone number format');
        }

        return true;
    }

// Getters et setters avec chaînage
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getcreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): void
    {
        $this->streetName = $streetName;
    }

    public
    function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public
    function setHouseNumber(?string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    public
    function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public
    function setPostCode(?string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public
    function getCity(): ?string
    {
        return $this->city;
    }

    public
    function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public
    function getEmail(): ?string
    {
        return $this->email;
    }

    public
    function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public
    function getSlug(): ?string
    {
        return $this->slug;
    }

    public
    function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }




    public
    function addProduct(Product $product): self
    {
        $this->products[] = $product;
        return $this;
    }

    public
    function getProducts(): array
    {
        return $this->products;
    }

    public
    function setProducts(array $products): void
    {
        $this->products = $products;
    }


    public
    function addOpeningHour(OpeningHours $openingHour): self
    {
        $this->openingHours[] = $openingHour;
        return $this;
    }

    public
    function getOpeningHours(): array
    {
        return $this->openingHours;
    }

    public
    function setOpeningHours(array $openingHours): void
    {
        $this->openingHours = $openingHours;
    }


    public
    function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public
    function setLogoName(?string $logoName): void
    {
        $this->logoName = $logoName;
    }

    public
    function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public
    function setLogoSize(?int $logoSize): void
    {
        $this->logoSize = $logoSize;
    }

    public
    function getLogoSize(): ?int
    {
        return $this->logoSize;
    }


    public
    static function fromArray(array $data): self
    {
        $dto = new self();

        foreach ($data as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($dto, $setter)) {
                $dto->$setter($value);
            }
        }

        return $dto;
    }

    public
    function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'vatNumber' => $this->vatNumber,
            'phoneNumber' => $this->phoneNumber,
            'description' => $this->description,
            'logoName' => $this->logoName,
            'logoSize' => $this->logoSize,
            'updatedAt' => $this->updatedAt?->format('Y-m-d H:i:s'),
            'streetName' => $this->streetName,
            'houseNumber' => $this->houseNumber,
            'postCode' => $this->postCode,
            'city' => $this->city,
            'email' => $this->email,
            'slug' => $this->slug,
        ];
    }
}