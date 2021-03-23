<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductCollection;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = Product::all();

            if (!$products) {
                return response()->json(['message' => 'No products on database!'], 404);
            }
            return new ProductCollection($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            $request->validate([
                'name' => 'required|max:120',
                'type' => 'required|in:Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal',
            ]);

            $product = new Product;
            $product->name = $request->name;
            $product->type = $request->type;
            $product->quantity = 0;
            $product->save();
    
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found!'], 404);
            } 
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|max:120',
                'type' => 'required|in:Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal',
                'quatity' => 'integer'
            ]);

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found!'], 404);
            }
            $product->name = $request->name;
            $product->type = $request->type;
            $product->quantity = $product->quantity + $request->quantity;
            $product->update();

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found!'], 404);
            } 
            $product->delete();

            return response()->json(['message' => 'Product deleted!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
