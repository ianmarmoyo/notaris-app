<?php

namespace App\Http\Requests;

use App\Models\WorkOrderDetail;
use App\Models\WorkOrderPayment;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WorkOrderPaymentRequest extends FormRequest
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
      'amount' => [
        'required',
        function ($attribute, $value, $fail) {
          if ($this->checkFirstPayment($value, $this->work_order_id)) {
            return $fail($this->checkFirstPayment($value, $this->work_order_id));
          }
        }
      ],
    ];
  }

  public function checkFirstPayment($value, $work_order_id)
  {
    $woPayment = WorkOrderPayment::where('work_order_id', $work_order_id)->sum('nominal') ?? false;
    $replace_amount = str_replace([',', '.', ' '], '', $value);
    if ($woPayment) {
      $getSisa = WorkOrderDetail::where('work_order_id', $work_order_id)->sum('harga') - $woPayment;
      if ($replace_amount > $getSisa) {
        return 'Uang yang dibayarkan melebihi sisa yang harus dibayarkan';
      }

      if ($replace_amount < $getSisa) {
        return 'Uang yang dibayarkan kurang dari sisa yang harus dibayarkan';
      }

      if ($getSisa <= 0) {
        return 'Pembayaran sudah selesai/lunas';
      }
    }
    return false;
  }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'code'       => 400,
      'message'   => $validator->errors()->first(),
    ], 400));
  }
}
