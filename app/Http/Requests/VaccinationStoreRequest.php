<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaccinationStoreRequest extends FormRequest
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
            'center_id' => ['required', 'integer', 'exists:vaccine_centers,id'],
            'date' => ['required', 'date', 'after:today', function ($attribute, $value, $fail) {
                $dayOfWeek = date('N', strtotime($value));
                if (in_array($dayOfWeek, [5, 6])) {//(Friday: 5, Saturday: 6)
                    $fail('The '.$attribute.' must be a weekday (Sunday to Thursday).');
                }
            }],
            'doze' => ['required', 'string', 'in:1st,2nd,3rd,4th'],
        ];
    }
}
