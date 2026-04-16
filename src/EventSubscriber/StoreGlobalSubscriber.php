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
        private readonly Environment     $twig,
        private string                   $environment
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
//        if (php_sapi_name() === 'cli' || getenv('APP_ENV') === 'test') {
//            return [];
//        }

        return [
            KernelEvents::CONTROLLER => ['onKernelController']
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
//// Ignore l'événement pendant les tests
//// ou les fixtures
//        if ($this->environment === 'test') {
//            $event->stopPropagation();
//            return;
//        }
//
//        // Alternative: vérifier si on est dans un contexte de commande
//        if (php_sapi_name() === 'cli') {
//            $event->stopPropagation();
//            return;
//        }

//        if (php_sapi_name() === 'cli' || $this->environment === 'test') {
//            // On crée un store "fictif" pour les tests
//            $this->twig->addGlobal('globalStore', new StoreDto());
//            $event->stopPropagation();
//            return;
//        }
//
//        if ($event->getRequest()->attributes->get('_controller') === 'hautelook_alice.console.command.doctrine.doctrine_orm_load_data_fixtures_command') {
//            return;
//        }


        $route = $event->getRequest()->attributes->get('_route');

        if ($route !== 'app_fallback' || !str_contains($route, 'admin_')) {

            $store = $this->storeRepository->myStore();

            if (null === $store) {
                return;
            }
            $storeDto = new StoreDto();
            $storeDto = $this->storeMapper->toDto($store);

            $this->twig->addGlobal('globalStore', $storeDto);
        }
    }
}
