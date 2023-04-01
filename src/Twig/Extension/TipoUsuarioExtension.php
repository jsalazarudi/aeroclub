<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TipoUsuarioExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TipoUsuarioExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('tipo_usuario', [TipoUsuarioExtensionRuntime::class, 'obtenerTipoUsuario']),
        ];
    }
}
