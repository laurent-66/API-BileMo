<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'allproducts', methods: ['GET'])]
    public function getAllProducts(
        ProductRepository $productRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $productList = $productRepository->findAll();
        $jsonproductList = $serializer->serialize($productList, 'json', ['groups' => 'getproducts']);
        return new JsonResponse($jsonproductList, Response::HTTP_OK, [], true);
    }
}
