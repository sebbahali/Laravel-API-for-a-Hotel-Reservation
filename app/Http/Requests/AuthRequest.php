<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id'=>'required', //'role_id' => 'required,exists:roles'
            //you should validate if the id exists in db
            //https://laravel.com/docs/10.x/validation#basic-usage-of-exists-rule
            //all the rules: https://laravel.com/docs/10.x/validation#available-validation-rules
            //you can make your custom rules as well
        ];
    }
}
