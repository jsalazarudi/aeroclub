<?php

namespace App\Form;

use App\Entity\Mensualidad;
use App\Entity\Servicio;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class MensualidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_inicio',DateTimeType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('fecha_fin',DateTimeType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[fecha_inicio].data'
                    ])
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
                ],
                'query_builder' => function (EntityRepository $er) {

                    return $er->createQueryBuilder('s')
                        ->where('s.es_mensual = true');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mensualidad::class,
        ]);
    }
}
