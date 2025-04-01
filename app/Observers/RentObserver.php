<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Rent;

class RentObserver
{
    public function updating(Rent $rent): void
    {
        if (in_array($rent->status, ['finished', 'failed'])) {
            $rent->finished_at = now()->toDateTimeString();
        }
    }
}
