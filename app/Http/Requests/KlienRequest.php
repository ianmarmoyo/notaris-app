<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class KlienRequest extends FormRequest
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
      'no_telp' => [
        'required',
        'numeric',
        'digits:12',
        Rule::unique('clients', 'no_telp')->ignore($this->id),
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
      'no_telp.required' => 'Nomor telepon wajib diisi.',
      'no_telp.numeric' => 'Nomor telepon harus berupa angka.',
      'no_telp.digits' => 'Nomor telepon harus terdiri dari 12 digit.',
      'no_telp.unique' => 'Nomor telepon sudah terdaftar.',
    ];
  }
}
