<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $categories = Category::where('user_id', $user)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Category List',
            'data' => $categories,
        ]);


    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:50',
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->user_id = Auth::user()->id;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category Created Successfully',
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
                'id' => 'required|integer',
            ]);

            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->user_id = Auth::user()->id;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $category = Category::find($request->id);
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Category Deleted Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
