<?php

namespace App\Enum;

final class TipoPessoa
{
    public const JURIDICA = 'J';
    public const FISICA = 'F';

    public static $choices = [
        self::JURIDICA => 'J',
        self::FISICA => 'F'
    ];
}