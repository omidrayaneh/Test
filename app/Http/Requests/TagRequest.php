<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|unique:tags',
            'description' => 'required|min:10',
            'photo_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'article title is required',
            'title.min'=>'article title is less more than 3 character',
            'title.unique'=>'article title is taken',
            'description.required'=>'article description is required',
            'description.min'=>'article description is less more than 10 character',
            'photo_id.required'=>'article photo is required',
        ];
    }
}
