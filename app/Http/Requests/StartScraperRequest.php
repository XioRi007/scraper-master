<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartScraperRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url' => 'url|required',
            'params' => 'array',
            'item_page_link_selector' => 'string|required',
            'next_page_selector' => 'string|required',
            'pod_count' => 'numeric|required'
        ];
    }
}