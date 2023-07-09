<?php

namespace App\Http\Requests;

use App\Tenant\Rules\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTable extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $id = $this->segment(3);
        return [
            'identify' => [
                'required', 
                'min:3', 
                'max:255',
                //"unique:tables,identify,{$id},id"],
                new UniqueTenant('tables', $id)
            ],
            'description' => ['required', 'min:3', 'max:1000'],
        ];
    }
}
