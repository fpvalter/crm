<?php

namespace App\Enum;

final class NegocioStatus
{
    public const ABERTO = 'ABERTO';
    public const FECHADO = 'FECHADO';
    public const PERDIDO = 'PERDIDO';

    public static $choices = [
        self::ABERTO => 'ABERTO',
        self::FECHADO => 'FECHADO',
        self::PERDIDO => 'PERDIDO'
    ];
}