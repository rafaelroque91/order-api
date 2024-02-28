<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Orders\OrderQuery;
use App\JsonApi\V1\Orders\OrderRequest;
use App\JsonApi\V1\Orders\OrderSchema;
use App\Models\Item;
use App\Services\OrderService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class OrderController extends AbstractController
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

    private const PRODUCTS_PATH = 'data.relationships.products';
    private const PRODUCTS_DATA_PATH ='data.relationships.products.data';
    private const CUSTOMER_PATH = 'data.relationships.customers';

    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function store(OrderSchema $schema, OrderRequest $request, OrderQuery $query): DataResponse
    {
        $this->manualRequestValidations($request);

     //   try {
            $order = $this->orderService->store($schema, $request, $query);

        return DataResponse::make($order)
            ->withQueryParameters($query)
            ->didCreate();

      /*   } catch (\Throwable $e) {
            $this->throwAPIError($e->getMessage(), 500, 'Unable to create Order', $e->getMessage());
        }*/
    }

    private function manualRequestValidations(OrderRequest $request): void
    {
        if (!request()->has(self::PRODUCTS_PATH)) {
            $this->throwAPIError(
                "The products field is required.",
                422,
                "Unprocessable Entity",
                "/data/relationships/products",
            );
        }

        $validator = $this->validateProductRequest($request);

        if ($validator->fails()) {
            $this->throwAPIError(
                json_encode($validator->errors()->all()),
                422,
                "Unprocessable Entity",
                "/data/relationships/products",
            );
        }
    }

    private function validateProductRequest(OrderRequest $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->input(self::PRODUCTS_DATA_PATH), [
            '*.id' => [
                'required',
                Rule::exists('products', 'id')->where(function ($query) use ($request) {
                    $query->where('customer_id', $request->validated('customer.id'));
                }),
            ],
            '*.quantity' => 'required',
        ], [
            'id.exists' => 'The selected product does not exist for this customer',
        ]);
    }
}
