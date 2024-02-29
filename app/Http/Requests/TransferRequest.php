<?php

namespace App\Http\Requests;

use App\Rules\CreditCardIsValid;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge(
            [
                'source' => str_replace('-', '', $this->convertToEnglish($this->source ?? '')),
                'destination' => str_replace('-', '', $this->convertToEnglish($this->destination ?? '')),
            ]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'source' => ['required', 'string', new CreditCardIsValid, 'exists:cards,number'],
            'destination' => ['required', 'string', new CreditCardIsValid, 'exists:cards,number'],
            'amount' => 'required|integer'
        ];
    }

    private function convertToEnglish($number)
    {
        // Define arrays mapping Persian/Arabic numbers to English
        $persianNumbers = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $arabicNumbers = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        $englishNumbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        // Replace Persian/Arabic numbers with English ones
        $convertedNumber = str_replace($persianNumbers, $englishNumbers, $number);
        $convertedNumber = str_replace($arabicNumbers, $englishNumbers, $convertedNumber);

        return $convertedNumber;
    }
}
