<?php

namespace App\Http\Requests;

use App\Models\Guru;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class GuruRequest extends FormRequest
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
    $checkWaliKelas = $this->waliKelasSudahDiisi();

    return [
      'jabatan' => [
        'nullable',
        function ($attribute, $value, $fail) {
          if ($this->jabatan == 'wali kelas' && !$this->kelas_id) {
            return $fail('Jabatan wali kelas harus menentukan kelas.');
          }
        },
      ],
      'kelas_id' => [
        'nullable',
        function ($attribute, $value, $fail) use ($checkWaliKelas) {
          if ($checkWaliKelas && $checkWaliKelas->count() > 0 && $this->jabatan == 'wali kelas') {
            return $fail('Kelas ini sudah ada wali kelas.');
          }
        },
      ],
      'phone' => [
        'required',
        'numeric',
        'digits:12',
        Rule::unique('gurus', 'no_telp')->ignore($this->id),
      ],
    ];
  }

  public function waliKelasSudahDiisi()
  {
    if (!$this->kelas_id) {
      return false;
    }

    $guru = Guru::where('jabatan', 'wali kelas')
      ->where('kelas_id', $this->kelas_id)
      ->get();

    return $guru;
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
