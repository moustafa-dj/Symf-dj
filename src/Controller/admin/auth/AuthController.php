<?php

namespace App\Controller\admin\auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('admin/login-form', name: 'admin.login-form', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('admin/auth/login.html.twig');
    }

    #[Route('admin/login',name:'admin.login' , methods:['GET','POST'])]
    public function login()
    {

    }
}
