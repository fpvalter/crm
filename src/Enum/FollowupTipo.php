<?php

namespace App\Entity;

final class FollowupTipo
{
    public const INFO = 'green';
    public const DANGER = 'danger';
    public const WARNING = 'warning';

    protected static $choices = [
        self::INFO => 'Info',
        self::DANGER => 'Danger',
        self::WARNING => 'Warning',
    ];
}