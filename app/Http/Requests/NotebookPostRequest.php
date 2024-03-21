<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class NotebookPostRequest extends FormRequest
{

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'status' => 'error',
    //         'message' => 'Bad Request',
            
    //     ], HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY));
    // }


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fio' => 'required',
            'company' => '',
            'phone' => 'required',
            'email' => 'required',
            'born_date' => '',
            'photo' => '',
        ];
    }
}
