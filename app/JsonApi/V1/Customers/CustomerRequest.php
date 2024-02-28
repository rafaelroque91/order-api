<?php

namespace App\JsonApi\V1\Customers;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class CustomerRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['required','string','unique:customers','min:3'],
        ];
    }

}
