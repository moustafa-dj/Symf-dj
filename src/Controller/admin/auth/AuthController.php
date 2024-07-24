<?php

namespace App\Controller\Admin\auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    public function index(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $last_username = $utils->getLastUsername();
        return $this->render('admin/auth/login.html.twig',[
            'controller_name' => 'LoginController',
            'last_username' => $last_username,
            'error'         => $error,
        ]);
    }

    public function login()
    {
        return $this->redirectToRoute('dashbord');
    }
    
}
