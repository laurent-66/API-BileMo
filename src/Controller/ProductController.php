<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    public function __construct(
        SerializerInterface $serializer,
        TagAwareCacheInterface $cachePool,
        CustomerRepository $customerRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository
        )
    {
        $this->serializer = $serializer;
        $this->cachePool = $cachePool;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    #[Route('/api/products', name: 'allproducts', methods:['GET'])]
    public function getAllProducts(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $idCache = "getAllProducts-" . $page . "-" . $limit;

        $allProducts = $this->cachePool->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            echo ("L'ELEMENT N'EST PAS ENCORE EN CACHE !\n");
            $item->tag("AllProductCache");
            return $this->productRepository->findAllWithPagination($page, $limit);
        });

        $jsonproductList = $this->serializer->serialize($allProducts , 'json', ['groups' => 'getproducts']);
        return new JsonResponse($jsonproductList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/products/{id}', name: 'detailproducts', methods:['GET'])]
    public function getDetailProduct( int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if($product === null) {
            return new JsonResponse(['message'=>'This product not exist'],Response::HTTP_NOT_FOUND);
        }

        $idCache = "getOneProduct";
        $oneProduct = $this->cachePool->get($idCache, function (ItemInterface $item) use ($id) {
            echo ("L'ELEMENT N'EST PAS ENCORE EN CACHE !\n");
            $item->tag("oneProductCache");
            return $this->productRepository->find($id);
        });

        $jsonProduct = $this->serializer->serialize($oneProduct , 'json', ['groups' => 'getproducts']);
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
}
