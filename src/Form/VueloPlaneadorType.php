<?php

namespace App\Form;

use App\Entity\VueloPlaneador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VueloPlaneadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tiempo_remolque', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('tiempo_libre', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('tema_vuelo', ChoiceType::class, [
                'choices' => [
                    'Adaptación' => 'adaptacion',
                    'Readaptación' => 'readaptacion',
                    'Entrenamiento' => 'entrenamiento',
                    'Instrucción' => 'instruccion'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Seleccione cual es el objetivo del vuelo'
            ])
            ->add('tiempo_acumulado', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('vuelo', VueloType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VueloPlaneador::class,
        ]);
    }
}
