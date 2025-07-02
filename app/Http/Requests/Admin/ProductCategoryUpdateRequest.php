<?php

namespace App\Http\Requests\Admin;

class ProductCategoryUpdateRequest extends ProductCategoryStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {    
        return [
            'name' => 'min:3|max:255|required|unique:product_category_test,name,'.$this->route('id'),
            'slug' => 'min:3|max:255|required',
            'status' => 'required'
        ];
    }
}
