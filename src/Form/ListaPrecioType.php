<?php

namespace App\Form;

use App\Entity\Avion;
use App\Entity\HistorialListaPrecio;
use App\Entity\ListaPrecio;
use App\Entity\Producto;
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
            ->add('precio', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('historial_lista_precio', EntityType::class, [
                'label' => '% Aumento',
                'class' => HistorialListaPrecio::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('servicio', EntityType::class, [
                'class' => Servicio::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Selecciona el servicio',
                'required' => false
            ])
            ->add('producto', EntityType::class, [
                'class' => Producto::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Selecciona el producto',
                'required' => false
            ])
            ->add('avion', EntityType::class, [
                'label' => 'Avión',
                'class' => Avion::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Selecciona el avión',
                'required' => false
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
            ->add('alumno', CheckboxType::class, [
                'label' => 'Precio para Alumno',
                'attr' => [
                    'class' => 'form-check-input fs-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'required' => false
            ])
            ->add('bautismo', CheckboxType::class, [
                'label' => 'Vuelo Bautismo',
                'attr' => [
                    'class' => 'form-check-input fs-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListaPrecio::class,
        ]);
    }
}
