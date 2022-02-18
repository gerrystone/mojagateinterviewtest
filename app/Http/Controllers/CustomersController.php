<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomersController extends Controller
{
   public function add_customer(CustomerRequest $request){
       $customer = Customer::create([
           'name'=>$request->name,
           'phone'=>$request->phone,
           'email'=>$request->email,
           'town'=>$request->town,
       ]);
       return back()->with('success', 'Customer Added Successfully');
   }
}
