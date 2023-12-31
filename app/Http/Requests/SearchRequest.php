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
           
            'adults'=> 'required|numeric',
            'children'=> 'required|numeric',
            'address'=> 'required|string',
            'from_price'=> 'required|numeric',
            'to_price'=> 'required|numeric',
            'sortOrder'=>'required|in:asc,desc',
            'sortBy' => 'required|in:price'
           
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
