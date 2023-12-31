<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     *from_price && $request->to_price // 'asc', 'desc'
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           
            'adults'=> 'numeric',
            'children'=> 'numeric',
            'address'=> 'string',
            'from_price'=> 'numeric',
            'to_price'=> 'numeric',
            'sortBy' => 'in:price|required_with:sortOrder',
            'sortOrder'=>'in:asc,desc|required_with:sortBy',
           
           
           
        ];
    }
    
    public function messages(): array
    {
        return [
            'sortBy.in' => "The 'sortBy' parameter accepts only 'price' value",
            'sortOrder.in' => "The 'sortOrder' parameter accepts only 'asc' and 'desc' values",
        ];
    }
}
