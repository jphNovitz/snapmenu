<?php

namespace App\Mapper;


use App\Dto\StoreDto;
use App\Entity\Store;

class StoreMapper
{
    public function toDto(Store $store)
    {
        $storeDto = new StoreDto();

        if (null !== $store->getName()) {
            $storeDto->setName($store->getName());
            $storeDto->setEmail($store->getEmail());
            $storeDto->setPhoneNumber($store->getPhoneNumber());
            $storeDto->setSlug($store->getSlug());
            $storeDto->setCreatedAt($store->getCreatedAt());
            $storeDto->setUpdatedAt($store->getUpdatedAt());
            $storeDto->setId($store->getId());
            $storeDto->setVatNumber($store->getVatNumber());
            $storeDto->setDescription($store->getDescription());
            $storeDto->setLogoName($store->getLogoName());
            $storeDto->setLogoName($store->getLogoName());
            $storeDto->setLogoSize($store->getLogoSize());
            $storeDto->setImageName($store->getImageName());
            $storeDto->setImageSize($store->getImageSize());
            $storeDto->setUpdatedAt($store->getUpdatedAt());
            $storeDto->setStreetName($store->getStreetName());
            $storeDto->setHouseNumber($store->getHouseNumber());
            $storeDto->setPostCode($store->getPostCode());
            $storeDto->setCity($store->getCity());
            $storeDto->setSlug($store->getSlug());
        }

        foreach ($store->getOpeningHours() as $openingHour) {
            $storeDto->addOpeningHour($openingHour);
        }
        
        return $storeDto;
    }


    public function toEntity(StoreDto $storeDto)
    {
        $store = $store ?? new Store();

        $this->hydrateStore($store, $storeDto);
        return $store;
    }

    public function updateEntity(Store $store, StoreDto $storeDto): Store
    {
        $this->hydrateStore($store, $storeDto);
        return $store;
    }

    public function hydrateStore(Store $store, StoreDto $storeDto)
    {
        $store->setName($storeDto->getName());
        $store->setEmail($storeDto->getEmail());
        $store->setSlug($storeDto->getSlug());
        $store->setCreatedAt($storeDto->getCreatedAt());
        $store->setUpdatedAt($storeDto->getUpdatedAt());
        $store->setVatNumber($storeDto->getVatNumber());
        $store->setDescription($storeDto->getDescription());
        $store->setLogoName($storeDto->getLogoName());
        $store->setLogoName($storeDto->getLogoName());
        $store->setLogoSize($storeDto->getLogoSize());
        $store->setImageName($store->getImageName());
        $store->setImageSize($store->getImageSize());
        $store->setUpdatedAt($storeDto->getUpdatedAt());
        $store->setStreetName($storeDto->getStreetName());
        $store->setHouseNumber($storeDto->getHouseNumber());
        $store->setPostCode($storeDto->getPostCode());
        $store->setCity($storeDto->getCity());
        $store->setSlug($storeDto->getSlug());

        foreach ($storeDto->getOpeningHours() as $openingHour) {
            $store->addOpeningHour($openingHour);
        }

        return $store;
    }
}