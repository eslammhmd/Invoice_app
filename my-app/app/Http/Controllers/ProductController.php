<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all_product(){
        $data = Product::orderBy('id' , 'DESC')->get();
        return response()->json([
            'products' => $data
        ],200);
    }
}
