<?php

namespace Tests\Feature\Orders;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class FeatureOrdersTest extends TestCase
{
    private $customer;
    private $products;
    private $order;
    private $items;
    private $inventories;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public static function dataProviderTestCreateOrder()
    {
        return [
            'with_stock' => [
                'products' => [
                    [
                        'stock' => 5,
                        'orderQuantity' => 2
                    ],
                    [
                        'stock' => 3,
                        'orderQuantity' => 1
                    ],
                ],
                'readyToShip' => true
            ],
            'without_stock' => [
                'products' => [
                    [
                        'stock' => 1,
                        'orderQuantity' => 2
                    ],
                    [
                        'stock' => 3,
                        'orderQuantity' => 1
                    ],
                ],
                'readyToShip' => false
            ],
            'with_same_stock' => [
                'products' => [
                    [
                        'stock' => 5,
                        'orderQuantity' => 5
                    ],
                    [
                        'stock' => 8,
                        'orderQuantity' => 8
                    ],
                ],
                'readyToShip' => true
            ],
        ];
    }

    private function factoryData($products) : void
    {
        $this->items = collect();
        $this->inventories = collect();

        $this->customer = Customer::factory()->create();
        $this->products = Product::factory(count($products))->create(['customer_id' => $this->customer->id]);
        $this->order = Order::factory()->create(['customer_id' => $this->customer->id]);
        foreach($this->products as $i=>$prod) {
            $this->inventories->push(
                Inventory::factory()->create(['product_id' => $prod->id, 'stock' => $products[$i]['stock']])
            );
            $this->items->push(
                Item::factory()->create(['order_id' => $this->order->id, 'product_id' => $prod->id, 'quantity' => $products[$i]['orderQuantity']])
            );
        }
    }

    /**
    * @dataProvider dataProviderTestCreateOrder
    */
    public function testCreateOrder($products, $readyToShip): void
    {
        $this->factoryData($products);

        $data = [
            'type' => 'orders',
            'attributes' => [
                'source' => $this->order->source,
                'recipientName' => $this->order->recipient_name,
                'recipientPhone' => $this->order->recipient_phone,
                'addressStreet' => $this->order->address_street,
                'addressNumber' => $this->order->address_number,
                'zipcode' => $this->order->zipcode,
            ],
            'relationships' => [
                'customer' => [
                    'data' => [
                        'type' => 'customers',
                        'id' => (string)$this->order->customer->id,
                    ],
                ],
                'products' => [
                    'data' => $this->items->map(fn(Item $item) => [
                        'type' => 'products',
                        'id' => (string)$item->product_id,
                        'quantity' => $item->quantity,
                    ])->all(),
                ],
            ],
        ];

        $response = $this
            ->jsonApi()
            ->expects('orders')
            ->withData($data)
            ->post('/api/v1/orders');

        $data = $this->compatibilityOrderData($data);

        $id = $response
            ->assertCreatedWithServerId('http://localhost/api/v1/orders', $data)
            ->id();

        $this->assertDatabaseHas('orders', [
            'id' => $id,
            'ready_to_ship' => $readyToShip
        ]);

        foreach ($this->products as $prod) {
            $this->assertDatabaseHas('items', [
                'order_id' => $id,
                'product_id' => $prod->id,
            ]);
        }
    }


    /**
     * @dataProvider dataProviderTestCreateOrder
     */
    public function testGetOrder($products, $readyToShip): void
    {
        $this->factoryData($products);
        $url = 'http://localhost/api/v1/orders/' . $this->order->getRouteKey();

        $data = $this->createOrderArray();

        $response = $this
            ->jsonApi()
            ->expects('orders')
            ->get($url);

        $data = $this->compatibilityOrderData($data);

        $response->assertFetchedOne($data);
    }

    private function createOrderArray()
    {
        return [
            'type' => 'orders',
            'attributes' => [
                'source' => $this->order->source,
                'recipientName' => $this->order->recipient_name,
                'recipientPhone' => $this->order->recipient_phone,
                'addressStreet' => $this->order->address_street,
                'addressNumber' => $this->order->address_number,
                'zipcode' => $this->order->zipcode,
            ],
            'relationships' => [
                'customer' => [
                    'data' => [
                        'type' => 'customers',
                        'id' => (string)$this->order->customer->id,
                    ],
                ],
                'products' => [
                    'data' => $this->items->map(fn(Item $item) => [
                        'type' => 'products',
                        'id' => (string)$item->product_id,
                        'quantity' => $item->quantity,
                    ])->all(),
                ],
            ],
        ];
    }

    private function compatibilityOrderData($data)
    {
        foreach ($data['relationships']['products']['data'] as $i=>$prod) {
            unset($data['relationships']['products']['data'][$i]['quantity']);
        };

        return $data;
    }
}
