<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryStoreRequest extends FormRequest
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
            'name' => 'min:3|max:255|required|unique:product_category_test,name',
            'slug' => 'min:3|max:255|required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Ten it nhat 3 ky ty tu',
            'name.max' => 'Ten nhieu nhat 255 ky ty tu',
            'name.required' => 'Ten buoc phai nhap',
            'status.required' => 'Trang thai phai chon'
        ];
    }
}
