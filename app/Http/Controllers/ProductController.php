<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request){
        $request->validated();

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
        ]);

        $data = [
            'id' => $product->id,
            'user_id' => $product->user_id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'min_stock' => $product->min_stock,
            'created_at' => $product->created_at,
        ];

        return response($data, 201);
    }

    public function index(){
        $products = Product::all()->map->only(['id', 'name', 'price', 'stock', 'min_stock']);

        return response($products, 200);
    }
}
