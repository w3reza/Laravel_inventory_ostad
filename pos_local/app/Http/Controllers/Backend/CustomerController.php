<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function CustomerCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:customers',
                'mobile' => 'required|numeric',
            ]);
            $userID = Auth::user()->id;
            Customer::create([
                'user_id' => $userID,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address')
            ]);
            $customerName = $request->input('name');
            return response()->json(["status" => "success", "message" => "Customer $customerName Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }


    public function CustomerList()
    {
        try {
            $userID = Auth::user()->id;
            $customer = Customer::where('user_id', $userID)->get();
            return response()->json(["status" => "success", "data" => $customer]);
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }


    public function CustomerByID(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;
            $customer = Customer::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($customer) {
                return response()->json(["status" => "success", "data" => $customer]);
            } else {
                return response()->json(["status" => "fail", "message" => "Category Not Found"]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }



    public function CustomerUpdate(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string|max:50',
                'mobile' => 'required|numeric'
            ]);

            $userID = Auth::user()->id;
            $customer = Customer::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($customer->email != $request->input('email')) {
                $request->validate([
                    'email' => 'required|email|unique:customers',
                ]);
            }
            if ($customer) {
                $customer->update([
                    'id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'address' => $request->input('address')
                ]);
                $customerName = $request->input('name');
                return response()->json(["status" => "success", "message" => "Customer $customerName Updated Successfully"]);
            } else {
                return response()->json(["status" => "fail", "message" => "Customer Not Found"]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }

    public function CustomerDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $userID = Auth::user()->id;
            $customer = Customer::where('id', $request->input('id'))->where('user_id', $userID)->first();
            if ($customer) {
                $customerName = $customer->name;
                $customer->delete();
                return response()->json(["status" => "success", "message" => "Customer $customerName Deleted Successfully"]);
            } else {
                return response()->json(["status" => "fail", "message" => "Customer Not Found"]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage()]);
        }
    }

}
