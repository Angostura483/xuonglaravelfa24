<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateCustomerRequest extends FormRequest
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
        $id = $this->route('customer');

        return [
                'name'      => 'required|max:255',
                'avatar'    => 'nullable|image|max:2048',
                'address'   => 'required|max:255',
                'phone'     => ['required', 'string', 'max:20', Rule::unique('customers')->ignore($id)],
                'email'     => 'required|email|max:100',
                'is_active' => ['nullable', Rule::in([0, 1])],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Trường địa chỉ email là bắt buộc.',
            'email.email' => 'Địa chỉ email phải hợp lệ.',
        ];
    }

    public function attributes() {
        return [
            'name' => 'tên',
            'email' => 'địa chỉ email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ], 422));
    }
}
