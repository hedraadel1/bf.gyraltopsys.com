<?php

namespace Modules\Cargo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You might want to change this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'from_country_id' => 'required|exists:countries,id',
            'from_state_id' => 'required|exists:states,id',
            'from_area_id' => 'required|exists:areas,id',
            'to_country_id' => 'required|exists:countries,id',
            'to_state_id' => 'required|exists:states,id',
            'to_area_id' => 'required|exists:areas,id',
            'shipping_cost' => 'required|numeric',
            'return_cost' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'insurance' => 'nullable|numeric',
            'mile_cost' => 'required|numeric',
            'return_mile_cost' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric|max:100', // Assuming percentage is between 0 and 100
            'discount_fixed_amount' => 'nullable|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Customize validation error messages here if needed
        ];
    }
}