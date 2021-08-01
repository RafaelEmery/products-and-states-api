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
    private const PRODUCT_NOT_FOUND = 'Product not found!';
    private $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        try {
            if (($allProducts = $this->products::all())->count() === 0) {
                return response()->json(['message' => 'No products on database!'], 404);
            }
            return new ProductCollection($allProducts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:120',
                'type' => 'required|string|max:20',
                'quantity' => 'required|integer|min:0'
            ]);

            return new ProductResource($this->products->create($request->all()));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            if (!$product = $this->products->find($id)) {
                return response()->json(['message' => self::PRODUCT_NOT_FOUND], 404);
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
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:120',
                'type' => 'required|string|max:20',
                'quantity' => 'required|integer|min:0'
            ]);


            if (!$product = $this->products->find($id)) {
                return response()->json(['message' => self::PRODUCT_NOT_FOUND], 404);
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
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $product = $this->products->find($id);

            if (!$product) {
                return response()->json(['message' => self::PRODUCT_NOT_FOUND], 404);
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
     * @return mixed
     */
    public function increments(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer'
            ]);

            if (!$product = $this->products->find($id)) {
                return response()->json(['message' => self::PRODUCT_NOT_FOUND], 404);
            }
            $calculate = new Calculate($product->quantity);
            $product->update([
                'quantity' => $calculate->increment($request->quantity)
            ]);

            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
