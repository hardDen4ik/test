<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository=$categoryRepository;
    }

    #[Route('api/v1.0/categories', name: 'categories')]
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->categoriesArray();

        return $this->json([
            'categories' => $categories
        ]);
    }
}
