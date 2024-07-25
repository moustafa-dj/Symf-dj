<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\ServiceMedia;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
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

            $files = $form->get('ServiceMedia')->getData();

            foreach ($files as $media) {

                $fileName = 'service_' . $service->getTitle() . '_' . uniqid() . '.' . $media->guessExtension();
                $directory = $this->getParameter('uploads_directory') . '/service';

                $media->move($directory, $fileName);
                $service_media = new ServiceMedia();
                $service_media->setPath($directory .'/'.$fileName);
                $service_media->setName($fileName);
                $service_media->setExtention($media->getExtension());
                $service_media->setService($service);

                $this->manager->persist($service_media);
                    
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

            $files = $form->get('ServiceMedia')->getData();

            if($files){
                foreach($service->getServiceMedia() as $media)
                {
                    $file_path = $media->getPath();
                    if(file_exists($file_path)){
                        unlink($file_path);
                    }
                    $this->manager->remove($media);

                }

                foreach ($files as $media) {

                    $fileName = 'service_' . $service->getTitle() . '_' . uniqid() . '.' . $media->guessExtension();
                    $directory = $this->getParameter('uploads_directory') . '/service';
    
                    $media->move($directory, $fileName);
                    $service_media = new ServiceMedia();
                    $service_media->setPath($directory .'/'.$fileName);
                    $service_media->setName($fileName);
                    $service_media->setExtention($media->getExtension());
                    $service_media->setService($service);
    
                    $this->manager->persist($service_media);
                        
                }
            }

            $this->manager->persist($service);
            $this->manager->flush();

            return $this->redirectToRoute('app_service_list');
        }

        return $this->render('admin/service/update.html.twig' , [
            'form' => $form,
            'service'=> $service
        ]);
    }

    #[Route('manager/service/delete/{id}',name:'app_service_delete' , methods:['GET'])]
    public function destroy(Service $service){
        
        foreach($service->getServiceMedia() as $media)
        {
            $this->manager->remove($media);

            if(file_exists($media->getPath()))
            {
                unlink($media->getPath());
            }

        }
        $this->manager->remove($service);
        $this->manager->flush();

        return $this->redirectToRoute('app_service_list');
    }
}
