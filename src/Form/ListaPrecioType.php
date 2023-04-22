<?php

namespace App\Form;

use App\Entity\HistorialListaPrecio;
use App\Entity\ListaPrecio;
use App\Entity\Servicio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListaPrecioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('precio',IntegerType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('historial_lista_precio',EntityType::class,[
                'label' => '% Aumento',
                'class' => HistorialListaPrecio::class,
                'choice_label' => 'porcentaje_cambio',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('servicio',EntityType::class,[
                'class' => Servicio::class,
                'choice_label' => 'descripcion',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('socio', CheckboxType::class, [
                'label' => 'Precio para Socio',
                'attr' => [
                    'class' => 'form-check-input fs-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'required' => false
            ])
//            ->add('producto_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListaPrecio::class,
        ]);
    }
}
