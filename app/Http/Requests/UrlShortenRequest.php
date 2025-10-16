<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlShortenRequest extends FormRequest
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
            'original_url' => 'required|url:http,https',
            'custom_code' => 'nullable|string|max:10|unique:short_links,code|regex:/^[A-Za-z0-9_-]+$/'
        ];
    }
}
