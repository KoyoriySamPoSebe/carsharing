<?php

declare(strict_types=1);

namespace App\Enums;

enum DriverStatus: string
{
    case DECLINE = 'decline';
    case WAIT_FOR_DOCS = 'wait_for_docs';
    case HAND_VERIFICATION = 'hand_verification';
    case APPROVE_CONDITION = 'approve_condition';
    case APPROVE = 'approve';
    case IN_PROCESS = 'in_process';
    case NEW = 'new';
}
