<?php

namespace App\Http\Controllers;

use App\Models\ExtraOption;
use App\Models\IceCream;
use App\Models\Order;
use App\Models\Product;
use App\Models\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CommunicationController extends Controller
{

    public function orderData()
    {
        return response()->json([
            'waffles' => $this->products(),
            'iceCreams' => $this->iceCreams(),
            'servings' => $this->servings(),
            'extraOptions' => $this->extraOptions(),
        ], 200);
    }

    public function products()
    {
        $products = Product::where('is_visible', true)->get([
            'id',
            'name',
            'is_visible'
        ]);

        $response = [];

        foreach ($products as $product) {
            $response[] = [
                'id' => Crypt::encrypt($product->id),
                'name' => $product->name,
            ];
        }

        return $response;
    }

    public function iceCreams()
    {
        $iceCreams = IceCream::where('is_visible', true)->get([
            'id',
            'name',
            'is_visible'
        ]);

        $response = [];

        foreach ($iceCreams as $iceCream) {
            $response[] = [
                'id' => Crypt::encrypt($iceCream->id),
                'name' => $iceCream->name,
            ];
        }

        return $response;
    }

    public function servings()
    {
        $servings = Serving::where('is_visible', true)->get([
            'id',
            'name',
            'is_visible'
        ]);

        $response = [];

        foreach ($servings as $serving) {
            $response[] = [
                'id' => Crypt::encrypt($serving->id),
                'name' => $serving->name,
            ];
        }

        return $response;
    }

    public function extraOptions()
    {
        $extraOptions = ExtraOption::where('is_visible', true)->get([
            'id',
            'name',
            'is_visible'
        ]);

        $response = [];

        foreach ($extraOptions as $extraOption) {
            $response[] = [
                'id' => Crypt::encrypt($extraOption->id),
                'name' => $extraOption->name,
            ];
        }

        return $response;
    }

    public function todayOrders()
    {
        $orders = Order::whereDate('created_at', today())->get([
            'status',
            'generated_id',
            'product_id'
        ]);

        $response = [];

        foreach ($orders as $order) {
            $response[] = [
                'status' => $order->status,
                'generated_id' => $order->generated_id,
                'product_id' => $order->product->name,
            ];
        }

        return response()->json($response, 200);
    }

    public function newOrder(Request $request)
    {
        return response()->json($request->all(), 200);
    }
}
