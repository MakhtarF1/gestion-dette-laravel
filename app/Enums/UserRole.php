<?php

namespace App\Enums;

enum UserRole: string
{
    case CLIENT = 'client';
    case BOUTIQUIER = 'boutiquier';
    case ADMIN = 'admin';

    // Retourne toutes les valeurs des énumérations sous forme de tableau
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
}

