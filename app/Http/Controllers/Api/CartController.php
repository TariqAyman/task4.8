<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    public function index()
    {
        $cart = json_decode(Cookie::get('cart'),true);

        return ApiHelper::output($cart);
    }


    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = json_decode(Cookie::get('cart'),true);
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            return ApiHelper::output( 'Product added to cart successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            return ApiHelper::output( 'Product added to cart successfully!');
        }

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];

        Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
        return ApiHelper::output( 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->get('id') && $request->get('quantity')) {
            $cart = json_decode(Cookie::get('cart'),true);
            $cart[$request->id]["quantity"] = $request->get('quantity');
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            return ApiHelper::output( 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = json_decode(Cookie::get('cart'),true);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            }
            return ApiHelper::output('Product removed successfully');
        }
    }

    public function empty_cart()
    {
        Cookie::queue(Cookie::forget('cart'));
        return ApiHelper::output('Products removed successfully');
    }
}
