<?php

namespace App\Model;

class Usuario
{
    public $tipo_usuario;

    /**
     * @return mixed
     */
    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }

    /**
     * @param mixed $tipo_usuario
     */
    public function setTipoUsuario($tipo_usuario): void
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    public static function getAvailableRoles()
    {
        return [
            'Alumno' => 1,
            'Socio' => 2,
            'Piloto' => 3,
            'Instructor' => 4,
            'Tesorero' => 5,
        ];
    }

    public function getRole()
    {
        return array_search($this->tipo_usuario, static::getAvailableRoles());
    }
}