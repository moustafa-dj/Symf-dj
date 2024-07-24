<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Service;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description' , TextareaType::class , [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price',NumberType::class ,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('domain', EntityType::class, [
                'class' => Domain::class,
                'choice_label' => 'name',
                'attr' =>  [
                    'class' => 'form-select'
                ]
            ])
            ->add('ServiceMedia' , FileType::class , [
                'mapped'=>false,
                'multiple'=>true,
                'attr' => [
                    'class'=>'form-control'
                ]
            ])
            ->add('submit' , SubmitType::class , [
                'attr'=> [
                    'class'=> 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
