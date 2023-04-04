<?php

namespace App\Form;

use App\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SocioType extends AbstractType
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('nombre', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('apellido', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('telefono', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Teléfono',
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('domicilio', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('ciudad', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ]
            ])
            ->add('fecha_vencimiento_licencia_medica', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Fecha Vencimiento Licencia Médica',
                'label_attr' => [
                    'class' => 'form-check-label text-muted fs-3'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label_attr' => [
                    'class' => 'text-muted fs-3'
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
            ->add('numero_socio', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'label' => 'Número Socio',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {

                $formData = $event->getData();
                /** @var Socio $socio */
                $socio = $event->getForm()->getData();

                if ($socio->getId()) {
                    $formData['password'] = $socio->getPassword();
                } else {
                    if ($formData['password']) {
                        $hashedPassword = $this->passwordHasher->hashPassword($socio, $formData["password"]);
                        $formData["password"] = $hashedPassword;
                    }
                }

                $event->setData($formData);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
