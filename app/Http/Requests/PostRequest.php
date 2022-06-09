<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $validate = [
            'title' => 'required|string|unique:posts,title',
            'description' => 'required|string|min:200',
            'tags' => 'required',
            'post_date' => 'required|date',
        ];

        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $validate['title'] = 'required|string|unique:posts,title,'.decrypt($this->route('post'));
        }

        return $validate;
    }

    public function attributes(){
        return [
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'post_date' => 'Date',
        ];
    }

    public function messages(){
        return [
            'required' => 'The :attribute is required.',
            'unique' => 'The value for the :attribute already exists.',
            'min' => 'The description should be atleast 200 charcters long.',
        ];
    }
}
