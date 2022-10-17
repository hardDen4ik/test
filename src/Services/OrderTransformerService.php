<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\Product;

class OrderTransformerService
{
    public static function toArray(Order $order, $products, $prod_ids): array
    {
        $result['order'] = [
            'id' => $order->getId(),
            'email' => $order->getEmail(),
            'total' => $order->getTotal(),
            'status' => $order->getStatus()
        ];
        foreach ($products as $product) {
            $result['products'][] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => $prod_ids[$product->getId()]
            ];
        }
        return $result;
    }
}