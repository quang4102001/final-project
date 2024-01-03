<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 1);

        if ($request->filled('categories')) {
            $categories = explode(',', $request->categories);
            $products->whereIn('category', $categories);
        }

        if ($request->filled('colors')) {
            $colors = explode(',', $request->colors);
            $products = $products->orWhereHas('colors',function ($query) use ($colors) {
                $query->whereIn('colors.id', $colors);
            });
        }
        if ($request->filled('sizes')) {
            $sizes = explode(',', $request->sizes);
            $product = $products->orWhereHas('sizes',function ($query) use ($sizes) {
                $query->whereIn('sizes.id', $sizes);
            });
        }

        // if ($request->filled('colors')) {
        //     $colors = explode(',', $request->colors);
        //     $products->orWhere(function ($query) use ($colors) {
        //         foreach ($colors as $color) {
        //             $query->orWhereHas('colors', function ($subQuery) use ($color) {
        //                 $subQuery->where('colors.id', $color);
        //             });
        //         }
        //     });
        // }
        
        // if ($request->filled('sizes')) {
        //     $sizes = explode(',', $request->sizes);
        //     $products->orWhere(function ($query) use ($sizes) {
        //         foreach ($sizes as $size) {
        //             $query->orWhereHas('sizes', function ($subQuery) use ($size) {
        //                 $subQuery->where('sizes.id', $size);
        //             });
        //         }
        //     });
        // }

        $products = $products->where('status', 1)->paginate(12)->onEachSide(1)->withQueryString();
        return view('users.index', compact('products'));
    }

    public function cart()
    {
        return view('users.cart');
    }
}
