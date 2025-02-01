<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
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
      'phone' => [
        'required',
        'numeric',
        'digits:12',
        Rule::unique('employees', 'no_telp')->ignore($this->id),
      ],
    ];
  }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'code'       => 400,
      'message'   => $validator->errors()->first(),
    ], 400));
  }

  public function messages(): array
  {
    return [
      'phone.required' => 'Nomor telepon wajib diisi.',
      'phone.numeric' => 'Nomor telepon harus berupa angka.',
      'phone.digits' => 'Nomor telepon harus terdiri dari 12 digit.',
      'phone.unique' => 'Nomor telepon sudah terdaftar di database guru.',
    ];
  }
}
