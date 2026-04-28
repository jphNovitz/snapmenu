<?php

namespace App\Twig\Components\Menu;

use App\Entity\Category;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CategorySection
{
    public Category $category;
    public int $index;
}
