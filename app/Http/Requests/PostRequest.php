<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|max:3',
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,png,mp4,mp3|max:20480',
            'category' => 'nullable|string|in:blog,news,tutorials',
            'user_id' => 'required|exists:users,id',
            'created_at' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
