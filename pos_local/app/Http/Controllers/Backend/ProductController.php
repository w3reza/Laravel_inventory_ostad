<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function ProductCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'unit' => 'required|numeric|max:50',
                'description' => 'string|max:255',
                'category_id' => 'required|integer',
            ]);

            // Image processing

            $request->validate([
                'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $userID = Auth::user()->id;
            // Prepare File Name & Path
            $image = $request->file('img_url');
            $t=time();
            $file_name=$image->getClientOriginalName();
            $img_name="{$userID}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";

            // Upload File
            $image->move(public_path('uploads'),$img_name);

            Product::create([
                'user_id' => $userID,
                'category_id' => $request->input('category_id'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'description' => $request->input('description'),
                'img_url' => $img_url


            ]);
            $ProductName = $request->input('name');
            return response()->json(["status" => "success", "message" => "Product $ProductName Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }


    public function ProductList()
    {
        try {
            $userID = Auth::user()->id;
            $Product = Product::where('user_id', $userID)->get();
            return response()->json(["status" => "success", "data" => $Product]);
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }


    public function ProductByID (Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;
            $Product = Product::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($Product) {
                return response()->json(["status" => "success", "data" => $Product]);
            } else {
                return response()->json(["status" => "fail", "message" => "Product Not Found"]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }



    public function ProductUpdate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'unit' => 'required|numeric|max:50',
                'description' => 'string|max:255',
                'category_id' => 'required|integer',
            ]);

            // Image processing

            // $request->validate([
            //     'img_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);

            $userID = Auth::user()->id;

            if ($request->hasFile('img_url')) {
                // Prepare File Name & Path
            $image = $request->file('img_url');
            $t=time();
            $file_name=$image->getClientOriginalName();
            $img_name="{$userID}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";

            // Upload File
            $image->move(public_path('uploads'),$img_name);

            // Delete Old File

            $oldFile = $request->input('old_file_path');
            File::delete($oldFile);

            // Product Update with Image

            Product::where('id', $request->input('id'))->where('user_id', $userID)->update([
                'category_id' => $request->input('category_id'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'description' => $request->input('description'),
                'img_url' => $img_url
                ]);

                 return response()->json(["status" => "success", "message" => "Product Updated Successfully"]);



            } else {

            // Without image Update
            Product::where('id', $request->input('id'))->where('user_id', $userID)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'description' => $request->input('description'),

                ]);
                 return response()->json(["status" => "success", "message" => "Product Updated Successfully"]);
            }




        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }


    public function ProductDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;

            $oldFile = $request->input('old_file_path');
            File::delete($oldFile);



            $Product = Product::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($Product) {
                $ProductName = $Product->name;
                $Product->delete();
                return response()->json(["status" => "success", "message" => "Product $ProductName Deleted Successfully"]);
            } else {
                return response()->json(["status" => "fail", "message" => "Product Not Found"]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }
}
