<?php
namespace App\Service;
use App\Contract\StoreManagerInterface;
use App\Entity\Store;
use App\Repository\StoreRepository;
final class StoreManager implements StoreManagerInterface
{
    public function __construct(private StoreRepository $storeRepository)
    {
    }
    public function create(Store $store): void
    {
        $this->storeRepository->save($store, true);
    }
    public function update(Store $store): void
    {
        $this->storeRepository->save($store, true);
    }
    public function delete(Store $store): void
    {
        $this->storeRepository->remove($store, true);
    }
}
