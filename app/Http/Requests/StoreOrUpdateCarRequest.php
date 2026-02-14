<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateCarRequest extends FormRequest
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
    //TODO : check exact format not just lenght
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_registered' => 'required|boolean',
            'registration_number' => [
                function ($attribute, $value, $fail) {
                    $isRegistered = (bool) request()->input('is_registered');


                    if ($isRegistered && (empty($value) || !preg_match('/^[A-Z]{2}[0-9]{3}[A-Z]{2}$/', $value))) {
                        $fail('Registration number must be in AA000AA format.');
                    }

                    if (!$isRegistered && !empty($value)) {
                        $fail('Registration number should be empty when not registered.');
                    }
                },
            ],
        ];
    }
}
