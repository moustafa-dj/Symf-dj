<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends AbstractController
{
    protected ServiceRepository $service;
    protected EntityManagerInterface $manager;

    public function __construct(ServiceRepository $service , EntityManagerInterface $manager)
    {
        $this->service = $service;
        $this->manager = $manager;
    }

    #[Route('manager/service', name: 'app_service_list')]
    public function index(): Response
    {
        $services = $this->service->findAll();

        return $this->render('admin/service/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('manager/service/create' , name:'app_service_create',methods:['GET','POST'])]
    public function create(Request $request){

        $service = new Service();
        $form = $this->createForm(ServiceType::class , $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();
            foreach ($service["ServiceMedia"] as $media) {
                $fileName = 'service_' . $service->getTitle() . 'img.' . $media->guessExtension(); // Ensure unique filenames
                $directory = $this->getParameter('uploads_directory') . '/service';

                try {
                    $media->move($directory, $fileName);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'File upload error: ' . $e->getMessage());
                }
            }

            $this->manager->persist($service);
            $this->manager->flush();

            return $this->redirectToRoute('app_service_list');
        }

        return $this->render('admin/service/create.html.twig', [
            'form'=>$form
        ]);
    }

    #[Route('manager/service/update/{id}',name:'app_service_update',methods:['GET','POST'])]
    public function update(Request $request , Service $service)
    {
        $form = $this->createForm(ServiceType::class , $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $service = $form->getData();
            $this->manager->persist($service);
            $this->manager->flush();

            return $this->redirectToRoute('app_service_list');
        }

        return $this->render('' , [
            'form' => $form,
            'service'=> $service
        ]);
    }

    #[Route('manager/service/delete/{id}',name:'app_service_delete' , methods:['GET'])]
    public function destroy(Service $service){
        
        $this->manager->remove($service);
        $this->manager->flush();

        return $this->redirectToRoute('app_service_index');
    }
}
