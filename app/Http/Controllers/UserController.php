<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $products = new Product;
        $products = $products->where('status', '1')->paginate(12)->onEachSide(1);
        return view('users.index', compact('products'));
    }

    public function cart()
    {
        return view('users.cart');
    }
}
