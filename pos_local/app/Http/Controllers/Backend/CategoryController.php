<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function CategoryCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
            ]);
            $userID = Auth::user()->id;
            Category::create([
                'user_id' => $userID, // 'user_id' => '1
                'name' => $request->input('name'),
            ]);
            return response()->json(['status' => 'success', 'message' => 'Category Created Successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CategoryList()
    {
        try {
            $userID = Auth::user()->id;
            $category = Category::where('user_id', $userID)->get();
            return response()->json(['status' => 'success', 'data' => $category]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function CategoryByID(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;
            $category = Category::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($category) {
                return response()->json(['status' => 'success', 'data' => $category]);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Category Not Found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function CategoryUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string|max:50',
            ]);
            $userID = Auth::user()->id;
            $category = Category::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($category) {
                $category->update([
                    'name' => $request->input('name'),
                ]);
                return response()->json(['status' => 'success', 'message' => 'Category Updated Successfully']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Category Not Found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CategoryDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;
            $category = Category::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($category) {
                $category->delete();
                return response()->json(['status' => 'success', 'message' => 'Category Deleted Successfully']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Category Not Found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
