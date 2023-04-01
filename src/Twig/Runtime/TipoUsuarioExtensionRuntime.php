<?php

namespace App\Twig\Runtime;

use App\Entity\Alumno;
use App\Entity\Instructor;
use App\Entity\Piloto;
use App\Entity\Socio;
use App\Entity\Tesorero;
use Twig\Extension\RuntimeExtensionInterface;

class TipoUsuarioExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }


    /**
     * @param Tesorero|Alumno|Instructor|Socio|Piloto $usuario
     * @return string
     */
    public function obtenerTipoUsuario(Tesorero|Alumno|Instructor|Socio|Piloto $usuario)
    {
       return get_class($usuario);
    }
}
