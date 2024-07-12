<?php

namespace App\Controller\admin\auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]

class AuthController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/auth/login.html.twig');
    }

    public function login()
    {

    }
}
