<?php

namespace App\Http\Requests;

use App\Enums\ActiveStatus;
use App\Models\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Spatie\Enum\Laravel\Rules\EnumRule;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  request()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_name" => ['required', 'string','max:255'],
            "description" => ['nullable', 'string'],
            "images" => ['required'],
            "images.*" => ['required', 'string'],
            "status" => ['required', new EnumRule(ActiveStatus::class)],
            "store_ids" => ['required'],
            "store_ids.*" => ['required', 'exists:stores,id'],
            //product_variants
            "product_variants" =>  ['required'],
            "product_variants.*.name"=> ['required', 'string'],
            "product_variants.*.stock_price" => ['required'],
            "product_variants.*.price"=> ['required'],
            "product_variants.*.stock"=> ['required', 'int'],
            "product_variants.*.status" => ['required', new EnumRule(ActiveStatus::class)],
            "product_variants.*.images" => ['required'],
            "product_variants.*.images.*" => ['required', 'string'],
            "product_variants.*.description" => ['nullable', 'max:1000']


        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
