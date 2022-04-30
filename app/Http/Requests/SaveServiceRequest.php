<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'=>'required',
            'name'=>'required',
            'address'=>'required',
            'description'=>'required',
            'price'=>'required',
            'city_id'=>'required',
            'category_id'=>'required',
            'image'=>[$this->route('service') ? 'nullable' : 'required', 'mimes:jpeg,png']
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>__('* Please enter a tittle'),
            'address.required'=>__('* Please enter a address'),
            'description.required'=>__('* Please enter a description'),
            'price.required'=>__('* Please enter a price for your service'),
            'city_id.required'=>__('* Please enter a city for your service'),
            'category_id.required'=>__('* Please enter a category for your service'),
            'image.required'=>__('* Please enter a image for your service'),
        ];
    }
}
