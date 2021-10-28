<?php

namespace App\Enum;

final class DiaEntrega
{
    public const SEGUNDA = 'SEGUNDA';
    public const TERCA = 'TERCA';
    public const QUARTA = 'QUARTA';
    public const QUINTA = 'QUINTA';
    public const SEXTA = 'SEXTA';
    public const SABADO = 'SABADO';
    public const DOMINGO = 'DOMINGO';

    public static $choices = [
        self::SEGUNDA => 'SEGUNDA',
        self::TERCA => 'TERCA',
        self::QUARTA => 'QUARTA',
        self::QUINTA => 'QUINTA',
        self::SEXTA => 'SEXTA',
        self::SABADO => 'SABADO',
        self::DOMINGO => 'DOMINGO',
    ];
}