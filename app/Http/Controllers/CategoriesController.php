<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function index(){
        return view("admin.categories.index");
    }

    public function create(){
        return view('admin.categories.create');
    }
}
