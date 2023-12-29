<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    /**
     *     $table->string('name');
            $table->string('discreption');
            $table->string('image');
            $table->string('address');
            $table->foreignId('user_id')->constrained();
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
            'name'=>'required|string',
            'discreption'=>'required|string',
        'image'=>'required|image|max:2048',
            'address'=>'required|string',
            'user_id'=>'required|exists:users,id',
        ];
    }
}
