<?php

namespace App\Http\Services;


use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class OrderService
{
    private ?Order $order = null;

    public function __construct()
    {
        return $this;
    }

    public function index(array $parameters)
    {
        $defaults = [
            'pageNumber' => 1,
            'rowsPerPage' => 20,
        ];

        $user = Auth::user('api');
        $parameters = array_merge($defaults, $parameters);
        $orders = Order::query();
        $orders->where('customer_id', $user->id);
        $count = $orders->count();
        $orders = $orders
            ->offset(($parameters['pageNumber'] - 1) * $parameters['rowsPerPage'])
            ->limit($parameters['rowsPerPage'])
            ->orderBy('id', 'desc')
            ->get();
        return [$orders, $count];
    }


    public function create(array $parameters)
    {
        $user = Auth::user('api');
        $products = [];
        foreach ($parameters['items'] as $item) {

            $product = Product::find($item['productId']);
            if ($product === null)
                throw new \Exception(Lang::get('Böyle bir ürün yok order olamaz'));

            if ($product->stock < $item['quantity'])
                throw new \Exception(Lang::get($product->name . ' için yeterli stok bulunamamaktadır'));

            $products[] = [
                'product' => $product,
                'item' => $item
            ];
        }

        $order = new Order();
        $order->customer_id = $user->id;
        $order->save();

        foreach ($products as $product) {
            OrderItem::insert([
                'order_id' => $order->id,
                'productId' => $product['product']->id,
                'quantity' => $product['item']['quantity'],
                'unitPrice' => $product['product']->price,
                'total' => $product['product']->price * $product['item']['quantity']
            ]);
            $product['product']->stock = $product['product']->stock - $product['item']['quantity'];
            $product['product']->save();
        }

        $discountOperations = Discount::orderBy('priority')->get();

        $order = Order::find($order->id);
        $currentPrice = $order->getTotal();
        foreach ($discountOperations as $discountOperation){
            $class = '\\App\\DiscountClasses\\'.$discountOperation->class_name;
            $class = new $class($order, $currentPrice);

            $discount = $class->calculate();
            if($discount <= 0)
                continue;

            $order->getDiscounts()->create([
                'discount_id' => $discountOperation->id,
                'discount' => $discount,
            ]);
        }

        return Order::find($order->id);

    }

    public function delete($id)
    {
        $user = Auth::user('api');

        $checkOrder = Order::where('customer_id', $user->id)->find($id);
        if ($checkOrder === null)
            throw new \Exception(Lang::get('Böyle bir order yok'));

        $checkOrder->getItems()->delete();
        $checkOrder->delete();
        return true;
    }

    public function getOrder($id)
    {
        $user = Auth::user('api');

        $order = Order::where('customer_id', $user->id)->find($id);
        if ($order === null)
            throw new \Exception(Lang::get('Böyle bir order yok'));

        return $order;
    }

}

