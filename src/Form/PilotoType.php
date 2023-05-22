<?php

namespace App\Form;

use App\Entity\Piloto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class PilotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_vencimiento_licencia_medica', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Fecha Vencimiento Licencia Médica',
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ],
                'constraints' => [
                    new GreaterThan('today')
                ]
            ])
            ->add('tipo_licencia', ChoiceType::class, [
                'choices' => [
                    'Piloto Privado' => 'piloto_privado',
                    'Piloto Comercial' => 'piloto_comercial',
                    'Aeroplicador' => 'aeroplicador'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('usuario',UsuarioType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piloto::class,
        ]);
    }
}
