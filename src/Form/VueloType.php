<?php

namespace App\Form;

use App\Entity\Avion;
use App\Entity\Curso;
use App\Entity\ReservaVuelo;
use App\Entity\Vuelo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VueloType extends AbstractType
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
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('es_vuelo_turistico', CheckboxType::class, [
                'label' => 'Es vuelo bautismo',
                'attr' => [
                    'class' => 'form-check-input fs-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'required' => false
            ])
            ->add('curso', EntityType::class, [
                'class' => Curso::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Seleccione el curso al que pertenece este vuelo',
                'query_builder' => function (EntityRepository $er) use ($options) {

                    return $er->createQueryBuilder('c')
                        ->where('c.alumno = :alumno')
                        ->andWhere('c.aprobado = false')
                        ->setParameter('alumno', $options['usuario']);

                }
            ])
            ->add('avion', EntityType::class, [
                'class' => Avion::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Seleccione el avión donde realizó el vuelo',
                'query_builder' => function (EntityRepository $er) use($options){

                    return $er->createQueryBuilder('a')
                        ->where('a.es_planeador = :es_planeador')
                        ->setParameter('es_planeador',$options['es_planeador']);
                }
            ])
            ->add('reservaVuelo',EntityType::class, [
                'class' => ReservaVuelo::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Seleccione la reserva realizada',
                'query_builder' => function (EntityRepository $er) use($options){

                    $reservasAprobadasQuery = $er->createQueryBuilder('rv')
                        ->join('rv.reserva','r')
                        ->join('rv.avion','a')
                        ->leftJoin('rv.vuelo','v')
                        ->where('r.aprobado = true')
                        ->andWhere('v.reservaVuelo IS NULL')
                        ->andWhere('a.es_planeador = :es_planeador')
                        ->setParameter('es_planeador',$options['es_planeador']);

                    if ($options['tipo_usuario'] === 'ROLE_SOCIO') {
                        $reservasAprobadasQuery->andWhere('r.socio = :socio')
                            ->setParameter('socio', $options['usuario']);
                    } elseif ($options['tipo_usuario'] === 'ROLE_PILOTO') {
                        $reservasAprobadasQuery->andWhere('r.piloto = :piloto')
                            ->setParameter('piloto', $options['usuario']);
                    }

                    return $reservasAprobadasQuery;

                }
            ])
            ->add('productoVuelos',CollectionType::class,[
                'entry_type' => ProductoVueloType::class,
                'entry_options' => ['label' => false],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype_options'  => [
                    'help' => 'Puedes registrar productos a este vuelo',
                ],
                'by_reference' => false,
                'label' => 'Productos utilizados en el Vuelo'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vuelo::class,
            'usuario' => null,
            'tipo_usuario' => null,
            'es_planeador' => false
        ]);
    }
}
