<?php

namespace App\Contract;

use App\Entity\Message;

interface MessageManagerInterface
{
    public function create(Message $message): void;

    public function update(Message $message): void;

    public function delete(Message $message): void;

}

