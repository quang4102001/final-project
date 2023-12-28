<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("admin.index");
    }

    public function checkLogin(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::commit();
            return view("admin.index");
        } catch (\Exception $e) {
            return redirect()->back()->withInput(request()->all())->with("error", "Login failed" . $e->getMessage() . $e->getLine());
        }
    }
}
