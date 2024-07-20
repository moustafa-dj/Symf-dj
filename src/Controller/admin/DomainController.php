<?php

namespace App\Controller\admin;

use App\Entity\Domain;
use App\Form\DomainType;
use App\Repository\DomainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DomainController extends AbstractController
{
    protected DomainRepository $domain;
    protected ValidatorInterface $validator;
    protected EntityManagerInterface $manager;

    public function  __construct(
        DomainRepository $domain,
        ValidatorInterface $validator,
        EntityManagerInterface $manager
    ) {
        $this->domain = $domain;
        $this->validator = $validator;
        $this->manager = $manager;
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

    #[Route('/manager/domain/store',methods:['POST'] , name:'app_domain_store')]
    public function store(Request $request){

        $domain = new Domain();

        $form = $this->createForm(DomainType::class , $domain);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $domain = $form->getData();

            $this->manager->persist($domain);

            $this->manager->flush();
        }

        return $this->redirectToRoute('app_admin_domain');
    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
