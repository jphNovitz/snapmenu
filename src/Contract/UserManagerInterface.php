<?php

namespace App\Contract;

use App\Entity\User;

interface UserManagerInterface
{
    public function preparePassword(User $user): void;
}

