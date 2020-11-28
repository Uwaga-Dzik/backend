<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'size' => 'nullable|integer|between:0,2',
//            'with_children' => 'nullable|boolean',
//            'alive' => 'nullable|boolean',
            'is_tracks' => 'nullable|boolean',
//            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'country' => 'nullable|string',
            'voivodeship' => 'nullable|string',
            'subregion' => 'nullable|string',
            'disctrict' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
        ];
    }
}
