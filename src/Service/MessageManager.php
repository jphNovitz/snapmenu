<?php

namespace App\Service;

use App\Contract\MessageManagerInterface;
use App\Entity\Message;
use App\Repository\MessageRepository;

final class MessageManager implements MessageManagerInterface
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    public function create(Message $message): void
    {
        $this->messageRepository->save($message, true);
    }

    public function update(Message $message): void
    {
        $this->messageRepository->save($message, true);
    }

    public function delete(Message $message): void
    {
        $this->messageRepository->remove($message, true);
    }
}

