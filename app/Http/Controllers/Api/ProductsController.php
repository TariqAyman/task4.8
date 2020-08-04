<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $products = Product::paginate(4);
        return ApiHelper::output($products);
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
        return ApiHelper::output($products);
    }
}
