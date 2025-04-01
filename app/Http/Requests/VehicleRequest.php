<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number'                => ['required', 'string', ' max:50'],
            'vin'                   => ['nullable', 'string', ' max:50'],
            'is_clean'              => ['required', 'boolean'],
            'is_available_for_rent' => ['required', 'boolean'],
            'is_door_opened'        => ['required', 'boolean'],
            'is_in_parking'         => ['required', 'boolean'],
            'rating'                => ['required', 'integer'],
            'fuel_in_tank'          => ['required', 'integer'],
            'location'              => ['nullable', 'string', 'regex:/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/'],
        ];
    }
}
