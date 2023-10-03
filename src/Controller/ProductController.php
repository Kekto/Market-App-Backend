<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController{

    #[Route('/products', name: 'products-init', methods: ['GET'])]
    public function init(): JsonResponse
    {
        return new JsonResponse([
            'test' => 'Success'
        ],200);
    }

}