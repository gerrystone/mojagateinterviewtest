<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
   public function add_customer(Request $request){
       $request->validate([
          'name'=>'required',
          'phone'=>'required:unique:customers',
          'email'=>'required|unique:customers',
           'town'=>'required'
       ]);
       $customer = new Customer();
       $customer->name=$request->name;
       $customer->phone=$request->phone;
       $customer->email=$request->email;
       $customer->town=$request->town;
       $customer->save();
       return back()->with('success', 'Customer Added Successfully');
   }
}
