<?php

namespace App\Contract;

use App\Entity\Store;

interface StoreManagerInterface
{
    public function create(Store $store): void;

    public function update(Store $store): void;

    public function delete(Store $store): void;

}

