<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderStoreRequest  $request
     *
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        $product = $request->getProductInstance();
        $quantity = $request->get('quantity');

        // sanity check: you know what it is
        if ($product->available_stock < $quantity) {
            return response()->json([
                'message' => 'Failed to order this product due to unavailability of the stock'
            ], 400);
        }

        $order = new Order();
        $order->product_id = $product->id;
        $order->quantity = $quantity;
        $order->save();

        // update the av stock of the product
        $product->available_stock = $product->available_stock - $order->quantity;
        $product->save();

        return response()->json([
            'message' => 'You have successfully ordered this product.'
        ], 201);
    }
}
