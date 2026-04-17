<?php

namespace App\Service;

use App\Contract\OpeningHoursManagerInterface;
use App\Entity\OpeningHours;
use App\Repository\OpeningHoursRepository;
use App\Repository\StoreRepository;

final class OpeningHoursManager implements OpeningHoursManagerInterface
{
    public function __construct(private OpeningHoursRepository $openingHoursRepository,
                                private StoreRepository $storeRepository)
    {
    }
    public function create(OpeningHours $openingHours): void
    {
        $openingHours->setStore($this->storeRepository->findOneBy([], ['id' => 'ASC']));
        $this->openingHoursRepository->save($openingHours, true);
    }

    public function update(OpeningHours $openingHours): void
    {
        $this->openingHoursRepository->save($openingHours, true);
    }

    public function delete(OpeningHours $openingHours): void
    {
        $this->openingHoursRepository->remove($openingHours, true);
    }

}

