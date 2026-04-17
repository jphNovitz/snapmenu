<?php

namespace App\Twig\Extension;

use App\Mapper\StoreMapper;
use App\Repository\StoreRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalStoreExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private StoreRepository $storeRepository,
        private StoreMapper $storeMapper
    ) {}

    public function getGlobals(): array
    {
        $store = $this->storeRepository->myStore();

        return [
            'globalStore' => $store ? $this->storeMapper->toDto($store) : null,
        ];
    }
}