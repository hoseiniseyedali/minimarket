<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $products = Product::latest()->paginate(12);
        return view('home', compact('products'));
    }
}