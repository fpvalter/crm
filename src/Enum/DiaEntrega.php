<?php

namespace App\Enum;

final class DiaEntrega
{
    public const SEGUNDA = 2;
    public const TERCA = 3;
    public const QUARTA = 4;
    public const QUINTA = 5;
    public const SEXTA = 6;
    public const SABADO = 7;
    public const DOMINGO = 8;

    protected static $choices = [
        self::SEGUNDA => 'SEGUNDA',
        self::TERCA => 'TERCA',
        self::QUARTA => 'QUARTA',
        self::QUINTA => 'QUINTA',
        self::SEXTA => 'SEXTA',
        self::SABADO => 'SABADO',
        self::DOMINGO => 'DOMINGO',
    ];
}