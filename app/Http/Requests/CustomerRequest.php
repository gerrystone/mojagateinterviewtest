<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>'required',
            'phone'=>'required:unique:customers',
            'email'=>'required|unique:customers',
            'town'=>'required'
        ];
    }
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
