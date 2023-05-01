<?php

namespace App\Form;

use App\Entity\Venta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('observaciones', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('fecha', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'widget' => 'single_text'
            ])
            ->add('productoVentas',CollectionType::class,[
                'entry_type' => ProductoVentaType::class,
                'entry_options' => ['label' => false],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'allow_add' => true,
                'prototype_options'  => [
                    'help' => 'Puedes registrar productos a esta venta',
                ],
                'by_reference' => false,
                'label' => 'Productos a comprar',
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venta::class,
        ]);
    }
}
