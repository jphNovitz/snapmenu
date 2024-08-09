<?php

namespace App\Twig\Components\Form;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Text
{

    public mixed $row;
    public string $label ;
    public string $placeholder = "";
}
