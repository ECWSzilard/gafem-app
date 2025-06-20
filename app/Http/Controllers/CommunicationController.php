<?php

namespace App\Http\Controllers;

use App\Models\ExtraOption;
use App\Models\IceCream;
use App\Models\Order;
use App\Models\Product;
use App\Models\Serving;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

    public function todayOrders(Request $request)
    {
        if ($request->has('date')) {
            $date = $request->date;
        } else {
            $date = today();
        }

        $orders = Order::whereDate('created_at', $date)->get([
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
        try {
            // Decrypt IDs
            $productId = Crypt::decrypt($request->waffle['id']);
            $servingId = Crypt::decrypt($request->serving['id']);

            // Create new order
            $order = new Order();
            $order->product_id = $productId;
            $order->serving_id = $servingId;
            $order->status = 'pending';
            $order->save();

            // Attach ice creams
            if (isset($request->iceCream) && is_array($request->iceCream)) {
                foreach ($request->iceCream as $iceCream) {
                    $iceCreamId = Crypt::decrypt($iceCream['id']);
                    $order->iceCreams()->attach($iceCreamId);
                }
            }

            // Attach extras
            if (isset($request->extras) && is_array($request->extras)) {
                foreach ($request->extras as $extra) {
                    $extraId = Crypt::decrypt($extra['id']);
                    $order->extraOptions()->attach($extraId);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Sikeresen létre lett hozva a rendelés',
                'order_id' => $order->generated_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sikeretelen rendelés létrehozva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function orders()
    {
        $orders = Order::groupBy(DB::raw('DATE(created_at)'))
            ->get([
                'created_at'
            ]);

        $response = [];

        foreach ($orders as $order) {
            $response[] = [
                'date' => Carbon::parse($order->status)->format('Y-m-d'),
            ];
        }

        return response()->json($response, 200);
    }

    public function orderDetails($id)
    {
        $order = Order::where('generated_id', $id)->first();

        $response = [];

        if ($order) {
            $response['id'] = $order->generated_id;
            $response['status'] = $order->status;
            $response['product'] = $order->product->name;
            $response['serving'] = $order->serving->name;
            $response['iceCreams'] = $order->iceCreams->pluck('name');
            $response['extras'] = $order->extraOptions->pluck('name');
        }

        return response()->json($response, 200);
    }

    public function changeStatus($id)
    {
        $order = Order::where('generated_id', $id)->first();

        if ($order) {
            if ($order->status == 'pending') {
                $order->status = 'done';
                $order->save();
            } else {
                return response()->json([
                    'response' => false,
                    'message' => 'Már frissítve volt a státusz!'
                ]);
            }
        }

        return response()->json([
            'response' => true,
            'message' => 'Sikeres státusz frissités'
        ]);
    }
}
