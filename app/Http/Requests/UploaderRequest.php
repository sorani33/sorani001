<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploaderRequest extends FormRequest
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
          'username'=>'required',
          'thum'=>'required|image',
      ];
    }


    public function messages()
    {
      return [
          "required" => "必須項目です。",
          "image" => "指定されたファイルが画像(jpg、png、bmp、gif、svg)ではありません。",
      ];
    }
}
