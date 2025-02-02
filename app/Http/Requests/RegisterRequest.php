<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:2|unique:users,name',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя пользователя не может быть пустым',
            'name.min' => 'Имя пользователя должно содержать минимум 2 символа',
            'name.unique' => 'Имя пользователя уже зарегистрировано',
            'email.required' => 'Email не может быть пустым',
            'email.unique' => 'Email уже зарегистрирован',
            'password.required' => 'Пароль не может быть пустым',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
        ];
    }
}
