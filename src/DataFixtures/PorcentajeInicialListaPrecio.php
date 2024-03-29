<?php

namespace App\DataFixtures;

use App\Entity\HistorialListaPrecio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PorcentajeInicialListaPrecio extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $historial = $manager->getRepository(HistorialListaPrecio::class)->findOneBy(['porcentaje_cambio' => 0]);

        if (!$historial) {
            $historialListaPrecio = new HistorialListaPrecio();
            $historialListaPrecio->setFecha(new \DateTime('now'));
            $historialListaPrecio->setPorcentajeCambio(0);

            $manager->persist($historialListaPrecio);
            $manager->flush();
        }

    }
}