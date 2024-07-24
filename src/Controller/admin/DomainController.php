<?php

namespace App\Controller\Admin;

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
    public function create(Request $request)
    {
        $domain = new Domain();

        $form = $this->createForm(DomainType::class , $domain);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $domain = $form->getData();

            $this->manager->persist($domain);

            $this->manager->flush();

            return $this->redirectToRoute('app_admin_domain');

        }

        return $this->render('admin/domain/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/manager/domain/update/{id}' , name:'app_domain_update' , methods:['GET','POST'])]
    public function update(Request $request , Domain $domain){

        $form = $this->createForm(DomainType::class,$domain);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $domain = $form->getData();

            $this->manager->persist($domain);

            $this->manager->flush();

            return $this->redirectToRoute('app_admin_domain');
        }
        return $this->render('admin/domain/update.html.twig',[
            'form'=>$form,
            'domain' => $domain
        ]);
    }
    #[Route('manager/domain/delete/{id}',name:'app_domain_delete' , methods:['GET'])]
    public function destroy(Domain $domain){

        $this->manager->remove($domain);

        $this->manager->flush();

        return $this->redirectToRoute('app_admin_domain');

    }
}
