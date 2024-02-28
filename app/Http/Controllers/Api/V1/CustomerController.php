<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Customers\CustomerCollectionQuery;
use App\JsonApi\V1\Customers\CustomerQuery;
use App\JsonApi\V1\Customers\CustomerRequest;
use App\JsonApi\V1\Customers\CustomerSchema;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class CustomerController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    public function store(CustomerSchema $schema, CustomerRequest $request, CustomerQuery $query)
    {
        $model = $schema
            ->repository()
            ->create()
            ->withRequest($query)
            ->store($request->validated());
        return new DataResponse($model);
    }
}
