<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $products = Product::where('user_id', $user)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Product List',
            'data' => $products,
        ]);


    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|integer',
                'unit' => 'required|integer|max:50',
                'description' => 'required|string|max:50',
                'img_url' => 'required|string|max:50',
                'category_id' => 'required|integer',
            ]);

            $product = new Product();
            $product->user_id = Auth::user()->id;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->unit = $request->unit;
            $product->img_url = $request->img_url;
            $product->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product Created Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|integer',
                'unit' => 'required|integer|max:50',
                'description' => 'required|string|max:50',
                'img_url' => 'required|string|max:50',
                'category_id' => 'required|integer',
            ]);

            $product = Product::find($request->id);
            $product->user_id = Auth::user()->id;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->unit = $request->unit;
            $product->img_url = $request->img_url;
            $product->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product Updated Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }






}
