<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    public function index()
    {
        return view('cart');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = json_decode(Cookie::get('cart'),true);
        if (!$cart) {
            $cart = [
                $id => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            return redirect()->back()->withSuccess('Product added to cart successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));

            return redirect()->back()->withSuccess('Product added to cart successfully!');
        }

        $cart[$id] = [
            "id" => $product->id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
        return redirect()->back()->withSuccess('Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            Cookie::queue(Cookie::make('cart', json_encode($cart), 60));
            session()->flash('success', 'Cart updated successfully');
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
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function empty_cart()
    {
        Cookie::queue(Cookie::forget('cart'));
        return redirect()->route('products')->withSuccess('Products removed successfully');
    }
}
