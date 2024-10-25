<?php

namespace App\EventSubscriber;

use App\Mapper\StoreMapper;
use App\Repository\StoreRepository;
use App\Dto\StoreDto;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class StoreGlobalSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly StoreRepository $storeRepository,
        private readonly StoreMapper     $storeMapper,
        private readonly Environment     $twig
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $store = $this->storeRepository->myStore();
        $storeDto = new StoreDto();
        $storeDto = $this->storeMapper->toDto($store);

        $this->twig->addGlobal('globalStore', $storeDto);
    }
}