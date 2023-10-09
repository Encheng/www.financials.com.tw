<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class AccountRequest extends FormRequest
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
        switch (
            Route::current()
                     ->getActionMethod()
        ) {
            case 'store':
                $rule = [
                    'name' => 'required|string',
                    'email' => 'required|email:rfc|unique:admins',
                    'role' => 'required|array',
                    'comment' => 'nullable|max:255',
                    'status' => 'required|boolean',
                ];
                break;
            case 'update':
                $rule = [
                    'name' => 'required|string',
                    'email' => 'required|email:rfc',
                    'role' => 'required|array',
                    'comment' => 'nullable|max:255',
                    'status' => 'required|boolean',
                ];
                break;
        }

        return $rule;
    }
}
