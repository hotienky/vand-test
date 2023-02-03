<?php

namespace App\Http\Requests;

use App\Enums\ActiveStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_id" => ['required', 'exists:products,id'],
            "name"=> ['required', 'string', 'max:255'],
            "stock_price" => ['required'],
            "price"=> ['required'],
            "stock"=> ['required', 'int'],
            "status" => ['required', new EnumRule(ActiveStatus::class)],
            "images" => ['required'],
            "images.*" => ['required', 'string'],
            "description" => ['nullable', 'max:1000']
        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
