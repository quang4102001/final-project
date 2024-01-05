<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->categories) {
            $categories = explode(',', $request->categories);
            $products->whereIn('category', $categories);
        }

        if ($request->colors) {
            $colors = explode(',', $request->colors);
            $products->orWhereHas('colors', function ($subQuery) use ($colors) {
                $subQuery->whereIn('colors.id', $colors);
            });
        }

        if ($request->sizes) {
            $sizes = explode(',', $request->sizes);
            $products->orWhereHas('sizes', function ($subQuery) use ($sizes) {
                $subQuery->whereIn('sizes.id', $sizes);
            });
        }

        $products = $products->where('status', 1)->paginate(12)->onEachSide(2)->withQueryString();
        return view('users.index', compact('products'));
    }

    public function cart()
    {
        return view('users.cart');
    }
}
