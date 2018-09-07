<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'name'=>'required|string',
            'email'=>'required|email:orders,email',
            'address'=>'required',
            'phone'=>'required|max:11'
        ];
    }
    public function messages(){
        return [
                'name.required'   =>'Vui lòng nhập họ và tên của người nhận',
                'email.required'  =>'Vui lòng nhập email của người nhận',
                'email.email'     =>'Không đúng định dạng của email',
                'address.required'=>'Vui lòng nhập địa chỉ của người nhận',
                'phone.required'  =>'Vui lòng nhập số điện thoại của người nhận',
                'phone.max'       =>'Số điện thoại phải ít nhất 11 kí tự'
        ];
    }
}
