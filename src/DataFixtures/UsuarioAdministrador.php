<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioAdministrador extends Fixture implements ContainerAwareInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private ContainerInterface $container;

    public function setContainer(?ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $dniAdministrador = '0000';
        $administrador = $manager->getRepository(Usuario::class)->findOneBy(['dni' => $dniAdministrador]);

        if (!$administrador) {

            $administrador = new Usuario();
            $administrador->setDni($dniAdministrador);
            $administrador->setNombre('Emilio');
            $administrador->setApellido('Castro');
            $administrador->setEmail('aeroclub.necochea@gmail.com');
            $administrador->setTelefono('123456');
            $administrador->setDomicilio('Aeroclub Necochea');
            $administrador->setCiudad('Necochea');
            $administrador->setPassword($this->passwordHasher->hashPassword($administrador, $this->container->getParameter('password_admin')));
            $administrador->setRoles(['ROLE_ADMINISTRADOR']);

            $manager->persist($administrador);
            $manager->flush();
        }

    }
}
