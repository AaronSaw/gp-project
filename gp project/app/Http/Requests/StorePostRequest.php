<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "title"=>"required|min:3|unique:posts",
            "category"=>"required|exists:categories,id",
            "description"=>"required|min:10",
            ////"featured_image"=>"nullable|mimes:png,jpg|file|max:512"
            ////size:value
        ];
    }
}
