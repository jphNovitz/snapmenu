<?php

namespace App\Dto;

    use App\Entity\Category;
    use App\Entity\Product;
    use App\Entity\OpeningHours;
    use DateTimeImmutable;
    use InvalidArgumentException;

class StoreDto
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $vatNumber = null;
    private ?string $phoneNumber = null;
    private ?string $description = null;
    private ?string $logoName = null;
    private ?int $logoSize = null;
    private ?DateTimeImmutable $updatedAt = null;
    private ?string $streetName = null;
    private ?string $houseNumber = null;
    private ?string $postCode = null;
    private ?string $city = null;
    private ?string $email = null;
    private ?string $slug = null;

    // Collections avec typage strict
    /** @var array<int, Category> */
    private array $categories = [];
    /** @var array<int, Product> */
    private array $products = [];
    /** @var array<int, OpeningHours> */
    private array $openingHours = [];

    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $phoneNumber = null
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
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


    public function addCategory(Category $category): self
    {
        $this->categories[] = $category;
        return $this;
    }

    public function addProduct(Product $product): self
    {
        $this->products[] = $product;
        return $this;
    }

    public function addOpeningHour(OpeningHour $openingHour): self
    {
        $this->openingHours[] = $openingHour;
        return $this;
    }

    public static function fromArray(array $data): self
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

    public function toArray(): array
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