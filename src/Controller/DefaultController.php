<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Mapper\StoreMapper;

class DefaultController extends AbstractController
{
    public function __construct(private StoreMapper $storeMapper)
    {
    }
    #[Route('/', name: 'app_default')]
    public function index(StoreRepository $storeRepository): Response
    {
        $stores = $storeRepository->findList();

        return $this->render('default/index.html.twig', [
            'stores' => $this->storeMapper->toDtoList($stores),
        ]);
    }
}
