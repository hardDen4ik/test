<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Services\OrderTransformerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
    private $validator;
    private $doctrine;

    public function __construct(ValidatorInterface $validator, ManagerRegistry $doctrine)
    {
        $this->validator = $validator;
        $this->doctrine = $doctrine;
    }

    #[Route('api/v1.0/order', name: 'order')]
    public function createOrder(Request $request): JsonResponse
    {
        $entityManager = $this->doctrine->getManager();
        if (empty($request->get('products'))) {
            return $this->json([
                'message' => 'no products in order'
            ]);
        }
        $products_ids = $request->get('products');
        $products = $entityManager->getRepository(Product::class)->findBy(['id' => array_keys($products_ids)]);
        $total = 0;
        foreach ($products as $product) {
            $total += $products_ids[$product->getId()] * $product->getPrice();
        }
        $order = new Order();
        $order->setEmail($request->get('email'));
        $order->setTotal($total);
        $order->setStatus(1);

        $errors = $this->validator->validate($order);
        if (count($errors) > 0) {
            return $this->json([
                'errors' => $errors
            ], 400);
        }
        $entityManager->persist($order);
        $entityManager->flush();

        foreach ($products as $product) {
            $op = new OrderProduct();
            $op->setProduct($product);
            $op->setOrder($order);
            $op->setQuantity($products_ids[$product->getId()]);
            $errors = $this->validator->validate($op);
            if (count($errors) > 0) {
                return $this->json([
                    'errors' => $errors
                ], 400);
            }
            $entityManager->persist($op);
            $entityManager->flush();
        }

        return $this->json(OrderTransformerService::toArray($order, $products, $products_ids));
    }
}
