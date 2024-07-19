<?php

namespace App\Controller\admin;

use App\Form\DomainType;
use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DomainController extends AbstractController
{
    protected DomainRepository $domain;

    public function  __construct(DomainRepository $domain) {
        $this->domain = $domain;
    }

    #[Route('/manager/domain', name: 'app_admin_domain')]
    public function index(): Response
    {
        $domains = $this->domain->findAll();

        return $this->render('admin/domain/index.html.twig',[
            'domains'=> $domains
        ]);
    }

    #[Route('manager/domain/create' , name:'app_domain_create',methods:['GET','POST'])]
    public function create()
    {
        $form = $this->createForm(DomainType::class);
        return $this->render('admin/domain/create.html.twig',[
            'form' => $form
        ]);
    }

    public function store(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
