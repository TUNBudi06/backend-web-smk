<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengumumanRequest extends FormRequest
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
            'pengumuman_nama' => 'required',
            'pengumuman_target' => 'required',
            'pengumuman_text' => 'required',
            'pengumuman_date' => 'required|date',
            'pengumuman_time' => 'required',
        ];
    }
}
