<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        //
        $products = Product::paginate(4);
        return view('products', compact('products'));
    }


    public function search(Request $request)
    {
        if (!empty($request->get('query'))) {
            $query = $request->get('query');
            $products = Product::where('name', 'LIKE', "%{$query}%")
                ->paginate(4);
        } else {
            $products = Product::paginate(4);
        }
        return view('list', compact('products'));
    }
}
