<?php

namespace App\Controller;

use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ManufacturerController extends AbstractController
{
    private $manufacturerRepository;

    public function __construct(ManufacturerRepository $manufacturerRepository)
    {
        $this->manufacturerRepository=$manufacturerRepository;
    }

    #[Route('api/v1.0/manufacturers', name: 'manufacturers')]
    public function index(): JsonResponse
    {
        $manufacturer = $this->manufacturerRepository->manufacturersArray();

        return $this->json([
            'manufacturer' => $manufacturer
        ]);
    }
}
