<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportSellingRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type_report' => 'required|string|in:selling,stock_transaction',
            'transaction_type' => 'required|string|in:daily,monthly,yearly',
            'year' => 'required_if:transaction_type,yearly,monthly|integer',
            'month' => 'required_if:transaction_type,monthly|integer|min:1|max:12',
            'start_date' => 'required_if:transaction_type,daily',
            'end_date' => 'required_if:transaction_type,daily',
        ];
    }
}
