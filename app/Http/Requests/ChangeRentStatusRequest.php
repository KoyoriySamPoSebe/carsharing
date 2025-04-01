<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeRentStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rentId'       => ['required', 'integer'],
            'targetStatus' => ['required', 'string', Rule::in(['reserve', 'prepare', 'driving', 'parking', 'finished', 'failed'])],
        ];
    }

    public function getRentId(): int
    {
        return $this->input('rentId');
    }

    public function getTargetStatus(): string
    {
        return $this->input('targetStatus');
    }
}
