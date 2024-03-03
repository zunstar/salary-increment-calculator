<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryIncrementRequest extends FormRequest
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
            'previousSalary' => 'required|numeric|min:1',
            'currentSalary' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'previousSalary.required' => '직전 연봉을 입력해주세요.',
            'previousSalary.numeric' => '직전 연봉은 숫자여야 합니다.',
            'previousSalary.min' => '직전 연봉은 0보다 커야 합니다.',
            'currentSalary.required' => '현재 연봉을 입력해주세요.',
            'currentSalary.numeric' => '현재 연봉은 숫자여야 합니다.',
            'currentSalary.min' => '현재 연봉은 0 이상이어야 합니다.',
        ];
    }
}
