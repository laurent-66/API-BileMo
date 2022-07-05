<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login', methods:['POST'])]
    public function index(): Response
    {
        $user = $this->getUser();

        // return new JsonResponse([
        //     'email' => $user->getEmail(),
        //     'roles' => $user->getRoles()
        // ]);

        return new Response("nouvelle Réponse");
    }
}
