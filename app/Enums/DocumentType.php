<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentType: string
{
    case PASSPORT = 'passport';
    case DRIVING_LICENSE = 'driving_license';
    case OTHER = 'other';
}
