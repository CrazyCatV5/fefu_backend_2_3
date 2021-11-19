<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppealPostRequest extends FormRequest
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
            'surname' => ['required','string','max:40'],
            'name' => ['required','string','max:20'],
            'patronymic' => ['nullable','string','max:20'],
            'age' => ['required','integer','between:14, 125'],
            'gender' => ['required', Rule::in([Gender::MALE, Gender::FEMALE])],
            'phone' => ['required_if:email,null','nullable','string', 'regex: /^((\+7)|7|8){1} \(\d{3}\) \d{2}-\d{2}-\d{3}$/'],
            'email' => ['required_if:phone,null','nullable','string','max:100','regex:/^([a-z0-9\_\-]+)(\.[a-z0-9\_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'message' => ['required','string','max:100'],
        ];
    }
}
