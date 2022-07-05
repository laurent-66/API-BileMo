<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login')]
    public function api_login(): JsonResponse
    {
        $currentCustomer = $this->getUser();

        return new JsonResponse([
            'email' => $currentCustomer->getEmail(),
            'roles' => $currentCustomer->getRoles()
        ]);

    }
}
