<?php

namespace App\Form;

use App\Entity\Curso;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descripcion', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('aprobado', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input fs-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'required' => false
            ])
            ->add('alumno', EntityType::class, [
                'class' => Usuario::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->join('u.alumno','a');
                },
                'placeholder' => 'Seleccione un alumno'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curso::class,
        ]);
    }
}
