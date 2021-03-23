<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductCollection;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Utils\Calculate;
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

            if ($products->count() == 0) {
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
                'name' => 'required|string|max:120',
                'type' => 'required|string|max:20',
                'quantity' => 'required|integer|min:0'
            ]);
            $product = Product::create($request->all());
    
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:120',
                'type' => 'required|string|max:20',
                'quantity' => 'required|integer|min:0'
            ]);
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found!'], 404);
            }
            $product->update($request->all());

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
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

    /**
     * Increments the quantity of a single product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function increments(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer'
            ]);
            $product = Product::find($id);
            $calculate = new Calculate($product->quantity);
    
            if (!$product) {
                return response()->json(['message' => 'Product not found!'], 404);
            }
        
            $incrementedQuantity = $calculate->increment($request->quantity);
            $product->update([
                'quantity' => $incrementedQuantity
            ]);
            
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
