<?php

namespace App\Form;

use App\Entity\MovimientoCuentaVuelo;
use App\Entity\VueloMotor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VueloMotorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choicesTipoVuelo =  [
            'Vuelo Privado' => 'Vuelo Privado',
            'Adaptación' => 'Adaptacion',
            'Readaptación' => 'Readaptacion',
            'Instrucción' => 'Instruccion'
        ];

        if ( $options['tipo_usuario'] === 'ROLE_ALUMNO') {
            $choicesTipoVuelo =  [
                'Instrucción' => 'instruccion'
            ];
        }


        $builder
            ->add('aterrizajes', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('pista_despegue', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('pista_aterrizaje', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('horometro_despegue', IntegerType::class, [
                'label' => 'Horómetro despegue',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('horometro_aterrizaje', IntegerType::class, [
                'label' => 'Horómetro aterrizaje',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('tipo_vuelo', ChoiceType::class, [
                'choices' => $choicesTipoVuelo,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'placeholder' => 'Seleccione el tipo de vuelo'
            ])
            ->add('vuelo', VueloType::class, [
                'usuario' => $options['usuario'],
                'tipo_usuario' => $options['tipo_usuario'],
                'is_new' => $options['is_new']
            ])
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                [$this, 'onPostSubmit']
            );
    }

    public function onPostSubmit(FormEvent $event): void
    {
        /** @var VueloMotor $vueloMotor */
        $vueloMotor = $event->getData();

        $unidadesGastadas = ($vueloMotor->getHorometroAterrizaje() - $vueloMotor->getHorometroDespegue()) / 10;

        if (!$vueloMotor->getVuelo()->getMovimientoCuentaVuelo()) {

            $movimientoCuentaVuelo = new MovimientoCuentaVuelo();
            $movimientoCuentaVuelo->setVuelo($vueloMotor->getVuelo());
            $movimientoCuentaVuelo->setUnidadesGastadas($unidadesGastadas);

            $vueloMotor->getVuelo()->setMovimientoCuentaVuelo($movimientoCuentaVuelo);
        } else {
            $movimientoCuentaVuelo = $vueloMotor->getVuelo()->getMovimientoCuentaVuelo();
            $movimientoCuentaVuelo->setUnidadesGastadas($unidadesGastadas);
        }


        $event->setData($vueloMotor);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VueloMotor::class,
            'usuario' => null,
            'tipo_usuario' => null,
            'is_new' => true
        ]);
    }
}
