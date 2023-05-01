<?php

namespace App\Form;

use App\Entity\Abono;
use App\Entity\MovimientoCuentaVuelo;
use App\Entity\ReservaHangar;
use App\Entity\Venta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'widget' => 'single_text'
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
            ->add('reservasHangar', EntityType::class, [
                'label' => 'Seleccione los hangarajes que desea cancelar:',
                'class' => ReservaHangar::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($options) {

                    $pendientesReservaHangar = $er->createQueryBuilder('rh')
                        ->join('rh.reserva', 'r')
                        ->where('r.aprobado = true')
                        ->andWhere('rh.abono IS NULL');


                    if ($options['tipo_usuario'] === 'ROLE_SOCIO') {
                        $pendientesReservaHangar->andWhere('r.socio = :socio')
                            ->setParameter('socio', $options['usuario']);
                    } elseif ($options['tipo_usuario'] === 'ROLE_PILOTO') {
                        $pendientesReservaHangar->andWhere('r.piloto = :piloto')
                            ->setParameter('piloto', $options['usuario']);
                    }

                    return $pendientesReservaHangar;

                },
                'choice_label' => function (ReservaHangar $reservaHangar) {
                    return sprintf("Fecha: %s Costo Unidades: %s", $reservaHangar->getReserva()->getFechaInicio()->format('Y-m-d'), $reservaHangar->getUnidadesGastadas());
                },
                'choice_attr' => function (ReservaHangar $reservaHangar, $key, $index) {
                    return ['class' => 'form-check-input me-2 ms-2'];
                }
            ])
            ->add('movimientoCuentaVuelos', EntityType::class, [
                'label' => 'Seleccione los vuelos que desea cancelar:',
                'class' => MovimientoCuentaVuelo::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($options) {

                    $movimientoCuentaVuelo = $er->createQueryBuilder('mcv')
                        ->join('mcv.vuelo', 'v')
                        ->where('mcv.abono IS NULL');

                    if ($options['tipo_usuario'] == 'ROLE_ALUMNO') {
                        $movimientoCuentaVuelo
                            ->join('v.curso', 'c')
                            ->andWhere('c.alumno = :alumno')
                            ->setParameter('alumno', $options['usuario']);

                    } elseif ($options['tipo_usuario'] == 'ROLE_SOCIO' || $options['tipo_usuario'] == 'ROLE_PILOTO' ) {
                        $movimientoCuentaVuelo->join('v.reservaVuelo', 'rv')
                            ->join('rv.reserva','r');

                        if ($options['tipo_usuario'] == 'ROLE_SOCIO') {
                            $movimientoCuentaVuelo->andWhere('r.socio = :socio')
                                ->setParameter('socio', $options['usuario']);
                        } else {
                            $movimientoCuentaVuelo->andWhere('r.piloto = :piloto')
                                ->setParameter('piloto', $options['usuario']);
                        }

                    }

                    return $movimientoCuentaVuelo;

                },
                'choice_attr' => function (MovimientoCuentaVuelo $vuelo, $key, $index) {
                    return ['class' => 'form-check-input me-2 ms-2'];
                }
            ])
            ->add('ventas', EntityType::class, [
                'label' => 'Seleccione las compras que desea cancelar:',
                'class' => Venta::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'text-muted fs-3'
                ],
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($options) {

                    $ventasQuery = $er->createQueryBuilder('v');

                    if ($options['tipo_usuario'] == 'ROLE_SOCIO') {
                        $ventasQuery->andWhere('v.socio = :socio')
                            ->setParameter('socio', $options['usuario']);
                    } else {
                        $ventasQuery->andWhere('v.piloto = :piloto')
                            ->setParameter('piloto', $options['usuario']);
                    }

                    return $ventasQuery;

                },
                'choice_attr' => function (Venta $venta, $key, $index) {
                    return ['class' => 'form-check-input me-2 ms-2'];
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abono::class,
            'tipo_usuario' => null,
            'usuario' => null
        ]);
    }
}
