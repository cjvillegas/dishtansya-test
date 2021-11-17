<?php

namespace App\Http\Requests\API;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ];
    }

    /**
     * Generate the product instance. We should never reach here if the product_id is invalid
     *
     * @return Product
     */
    public function getProductInstance(): Product
    {
        return Product::find($this->get('product_id'));
    }
}
