<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CustomerController extends AbstractController
{
    #[Route('api/customers/{id}/users', name: 'allUsersToOneCustomer', methods:['GET'])]
    public function getAllUserstoOneCustomer(int $id, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {

        //check if connected user have an id equals to $id
        // if($id !== $this->getUser()->getId()) {
        //     return new JsonResponse(['message'=>'You are not allowed to access this page']);
        // }

        $usersListToCustomer = $userRepository->findByCustomer($id);

        $jsonUsersListToCustomer = $serializer->serialize($usersListToCustomer, 'json', ['groups' => 'getusers']);
        return new JsonResponse($jsonUsersListToCustomer, Response::HTTP_OK, [], true);
    }

    #[Route('api/customers/{id}/users/{userId}', name: 'detailUserToOneCustomer', methods:['GET'])]
    public function getDetailUsertoOneCustomer(
        int $id, 
        int $userId, 
        UserRepository $userRepository, 
        SerializerInterface $serializer): JsonResponse
    {

        //check if connected user have an id equals to $id
        // if($id !== $this->getUser()->getId()) {
        //     return new JsonResponse(['message'=>'You are not allowed to access this page'], Response::HTTP_FORBIDDEN);
        // }

        //check if $id user asked  exist well
        $user = $userRepository->find($userId);
        if($user === null) {
            return new JsonResponse(['message'=>'This user not exist'],Response::HTTP_NOT_FOUND);
        }

        $jsonDetailUsers = $serializer->serialize($userId, 'json', ['groups' => 'getusers']);
        return new JsonResponse($jsonDetailUsers, Response::HTTP_OK, [], true);
    }


    #[Route('api/customers/{id}/users', name: 'postUserToOneCustomer', methods:['POST'])]
    public function createUsertoOneCustomer(
        int $id, 
        Request $request, 
        CustomerRepository $customerRepository, 
        SerializerInterface $serializer,
        EntityManagerInterface $emi,
        UrlGeneratorInterface $urlGenerator): JsonResponse
    {

        //check if connected user have an id equals to $id
        // if($id !== $this->getUser()->getId()) {
        //     return new JsonResponse(['message'=>'You are not allowed to access this page'], Response::HTTP_FORBIDDEN);
        // }

        $customer = $customerRepository->find($id);
        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json', ['groups'=> 'postusers']); 

        $newUser->setCustomer($customer);
        $newUser->setCreatedAt(new \DateTime());
        $newUser->setUpdatedAt(new \DateTime());
        $emi->persist($newUser);
        $emi->flush();
        $jsonNewUser = $serializer->serialize($newUser,'json', ['groups' => 'getUsers']);
        $location = $urlGenerator->generate('detailUserToOneCustomer', ['id'=>$customer->getId(), 'userId'=>$newUser->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonNewUser, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('api/customers/{id}/users/{userId}', name: 'deleteUserToOneCustomer', methods:['DELETE'])]
    public function deleteUsertoOneCustomer( 
        int $id, 
        int $userId, 
        UserRepository $userRepository,  
        EntityManagerInterface $emi): JsonResponse

    {
        //check if connected user have an id equals to $id
        // if($id !== $this->getUser()->getId()) {
        //     return new JsonResponse(['message'=>'You are not allowed to access this page'], Response::HTTP_FORBIDDEN);
        // }

        //check if $id user asked  exist well
        $user = $userRepository->find($userId);
        if($user === null) {
            return new JsonResponse(['message'=>'This user not exist'],Response::HTTP_NOT_FOUND);
        }

        $usersListToCustomer = $userRepository->findByCustomer($id);

        foreach($usersListToCustomer as $currentUser) {
                $emi->remove($currentUser);
                $emi->flush();
                return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

    }
}
