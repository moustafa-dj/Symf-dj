<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EquipmentController extends AbstractController
{
    protected $equipment;
    protected $manager;
    public function __construct(EntityManagerInterface $manager , EquipmentRepository $equipment)
    {
        $this->manager = $manager;
        $this->equipment = $equipment;
    }

    #[Route('/equipment', name: 'app_equipment_list')]
    public function index(): Response
    {
        $equipments = $this->equipment->findAll();

        return $this->render('equipment/index.html.twig', [
            'equipments' => $equipments,
        ]);
    }

    #[Route('/equipment/create' , name:'equipment.store',methods:['POST','GET'])]
    public function create(Request $request)
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class , $equipment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $equipment = $form->getData();

            $this->manager->persist($equipment);
            $this->manager->flush();

            return $this->redirectToRoute('app_equipment_list');
        }

        return $this->render('equipment/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('equipment/update/{id}' , name:'equipment_update',methods:['POST','GET'])]
    public function update(Request $request , $id)
    {
        $equipment = $this->equipment->findOneBy(['id'=>$id]);

        $form = $this->createForm(EquipmentType::class , $equipment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $equipment = $form->getData();

            $this->manager->persist($equipment);
            $this->manager->flush();

            return $this->redirectToRoute('app_equipment_list');
        }
        
        return $this->render('equipment/update.html.twig',[
            'form' => $form,
            'equipment' => $equipment,
        ]);
    }

    #[Route('/equipment/{id}' , name:'equipment_details' , methods:['GET'])]
    public function show($id)
    {
        $equipment = $this->equipment->findOneBy(['id' => $id]);

        return $this->render('requipment/details.html.twig',[
            'equipment' => $equipment,
        ]);
    }

    #[Route('equipment/delete/{id}' ,name:'equipemnt_delete',methods:['GET'])]
    public function destroy($id)
    {
        $equipment = $this->equipment->findOneBy(['id'=> $id]);

        $this->manager->remove($equipment);
        $this->manager->flush();

        return $this->redirectToRoute('app_equipment_list');
    }
}
