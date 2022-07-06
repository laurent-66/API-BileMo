<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login')]
    public function api_login(): JsonResponse
    {
        $currentCustomer = $this->getUser();

        if (null === $currentCustomer) {
            return new JsonResponse([
            'message' => 'missing credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'email' => $currentCustomer->getUserIdentifier(),
            'roles' => $currentCustomer->getRoles()
        ]);
    }
}
