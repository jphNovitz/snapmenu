<?php

namespace App\Contract;

use App\Entity\OpeningHours;

interface OpeningHoursManagerInterface
{
    public function create(OpeningHours $openingHours): void;

    public function update(OpeningHours $openingHours): void;

    public function delete(OpeningHours $openingHours): void;

}

