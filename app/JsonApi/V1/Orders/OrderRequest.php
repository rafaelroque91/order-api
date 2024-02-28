<?php

namespace App\JsonApi\V1\Orders;

use LaravelJsonApi\Laravel\Http\Requests\FormRequest;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use Illuminate\Validation\Factory as ValidationFactory;

class OrderRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'customer' => JsonApiRule::toOne(),
            'source' => ['required','string'],
            'recipientName' => ['required','string'],
            'recipientPhone' => ['required','string'],
            'addressStreet' => ['required','string'],
            'addressNumber' => ['required','string'],
            'zipcode' => ['required','string'],
            'products' => JsonApiRule::toMany(),
        ];
    }
}
