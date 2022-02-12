<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrokerFormRequest extends FormRequest
{
    const DATE_FORMAT = 'Y-m-d';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'startDate' => 'required|date|date_format:' . static::DATE_FORMAT,
            'endDate' => 'required|date|after:startDate|before:tomorrow|date_format:' . static::DATE_FORMAT,
            'amount' => 'required|numeric|gt:0',
        ];
    }
}
