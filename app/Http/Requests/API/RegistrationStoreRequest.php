<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegistrationStoreRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:191',
                'unique:users,email'
            ],
            'password' => 'required|string'
        ];
    }

    /**
     * As instructed we need to specifically return an error code 400 for failed validations
     * By default Laravel return 422 error code for failed validations, this method will override it.
     *
     * @param Validator $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // build the response json
        $response = new JsonResponse(
            [
                'message' => 'Email already taken',
                'errors' => $validator->errors()
            ], 400);

        throw new ValidationException($validator, $response);
    }
}
