<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    #[Route('api/customers/{id}/users', name: 'allUsersToOneCustomer', methods:['GET'])]
    public function getAllUserstoOneCustomer(int $id, CustomerRepository $customerRepository, SerializerInterface $serializer): JsonResponse
    {
        $customer = $customerRepository->find($id);
        $usersListToCustomer = $customer->getUsers();
        $jsonUsersListToCustomer = $serializer->serialize($usersListToCustomer, 'json', ['groups' => 'getusers']);
        return new JsonResponse($jsonUsersListToCustomer, Response::HTTP_OK, [], true);
    }

    #[Route('api/customers/{id}/users/{userId}', name: 'detailUserToOneCustomer', methods:['GET'])]
    public function getDetailUsertoOneCustomer(int $id, int $userId, CustomerRepository $customerRepository, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $customer = $customerRepository->find($id);
        $usersListToCustomer = $customer->getUsers();

        foreach($usersListToCustomer as $user) {
            if($user->getId() === $userId ) {
                $detailUser = $userRepository->find($userId);
                $jsonDetailUsers = $serializer->serialize($detailUser, 'json', ['groups' => 'getusers']);
                return new JsonResponse($jsonDetailUsers, Response::HTTP_OK, [], true);
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);

    }







}
