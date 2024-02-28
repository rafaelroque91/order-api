<?php

namespace App\Services;

use App\JsonApi\V1\Orders\OrderQuery;
use App\JsonApi\V1\Orders\OrderRequest;
use App\JsonApi\V1\Orders\OrderSchema;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class OrderService
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    private function checkThereIsStock(array $products) : bool
    {
        $productIds = array_map(function ($product) {
            return $product['id'];
        }, $products);

        $dbProds = $this->productRepository->getProductStockbyIds($productIds);

        foreach($products as $prod)
        {
            if ($dbProds->find($prod['id'])->inventory?->stock < $prod['quantity']) {
                return false;
            }
        }
        return true;
    }
    public function store(OrderSchema $schema, OrderRequest $request, OrderQuery $query)
    {
        $orderRequest = $request->validated();
        try {
            $products = $request->validated('products');
            $orderRequest['readyToShip']  = $this->checkThereIsStock($products);

            DB::beginTransaction();
            $order = $schema
                ->repository()
                ->create()
                ->withRequest($query)
                ->store($orderRequest);

            $this->updateItemsQuantity($orderRequest, $order);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('error to create order', ['message' => $e]);
            throw $e;
        }
        return $order;
    }

    private function updateItemsQuantity($request, $order): void
    {
        //hack to fix a limitation of the library. many-many relationships, we cant update the others fields.
        // So we need to do it manually
        foreach ($request['products'] as $prod) {
            $item = $order->items->where('product_id',$prod['id'])->first();
            $item->quantity = $prod['quantity'];
            $item->save();
        }
    }
}
