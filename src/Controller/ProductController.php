<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }

    #[Route('api/v1.0/products', name: 'products')]
    public function index(Request $request): JsonResponse
    {
        $products = $this->productRepository->productsArray($request);

        return $this->json([
            'products' => $products
        ]);
    }
}
