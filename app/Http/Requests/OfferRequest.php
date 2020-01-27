<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Route;
use Illuminate\Support\Collection;

class OfferRequest extends FormRequest
{

    public static $rules = [
        'selectedDesign'  => 'required',
    ];
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
        $id = @$this->ruleset->id;
        $shop_id = \ShopifyApp::shop()->id;

        if(empty($id)) {
            $id = null;
        }

        $rules = self::$rules;
        switch (Route::currentRouteName()) {
            case 'offers.store':
                {
                    $rules['ruleset_name'] = "required|unique:rulesets,ruleset_name,{$id},id,shop_id,{$shop_id}";
                    $rules['tier_pricing'] = 'required|checkzero';
                    return $rules;
                }
            case 'offers.update':
                {
                    $rules['ruleset_name'] = "required|unique:rulesets,ruleset_name,{$id},id,shop_id,{$shop_id}";
                    $rules['tier_pricing'] = 'required|checkzero';
                    return $rules;
                }
            case 'admin.bundles.create':
                {
                    return [];
                }
            default:
                break;
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'selectedDesign.required' => 'Add atleast one product',
            'tier_pricing.required' => 'One of the quentity is 0 or value is blank',
            'tier_pricing.checkzero' => 'The quantity must be greater than 0',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax() || $this->wantsJson()) {
            $response = new JsonResponse($validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
