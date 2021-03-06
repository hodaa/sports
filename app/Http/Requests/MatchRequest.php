<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
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
            "week_id" => 'required|exists:weeks,id',
            "title"=>'required',
            "description" =>"required",
            "image"=> "mimes:jpeg,png,gif|max:1014"
        ];
    }
}
