<?php

namespace App\Enum;

final class ClienteTipoCompra
{
    public const CURVA_ABC = 'CURVA_ABC';
    public const RODEIRO = 'RODEIRO';
    public const NACIONAL = 'NACIONAL';
    public const IMPORTADO = 'IMPORTADO';
    public const PNEU_CARGA = 'PNEU_CARGA';

    public static $choices = [
        self::CURVA_ABC => 'CURVA_ABC',
        self::RODEIRO => 'RODEIRO',
        self::NACIONAL => 'NACIONAL',
        self::IMPORTADO => 'IMPORTADO',
        self::PNEU_CARGA => 'PNEU_CARGA'
    ];
}