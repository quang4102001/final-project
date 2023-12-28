<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function index()
    {

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view("index", compact("categories", "colors", "sizes"));
    }
}
