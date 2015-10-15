<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CalculateRequest extends Request
{
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
            'principal' => "required|numeric",
            'termLength' => "required|numeric|integer",
            'termLengthType' => "required|alpha|in:years,months",
            'rate' => "required|numeric",
        ];
    }
}
