<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function all_customer(){
        $data = Customer::orderBy('id' , 'DESC')->get();
        return response()->json([
            'customers' => $data
        ],200);
    }
}
