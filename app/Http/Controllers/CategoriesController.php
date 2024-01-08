<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    const PAGINATION = 50;

    public function index(Request $request)
    {
        $categories = Category::query();

        if ($request->SearchCategoryName) {
            $categories->where('name', 'LIKE', '%' . $request->SearchCategoryName . '%');
        }

        $categories = $categories->paginate($request->pagination ?? static::PAGINATION)->appends($request->all());

        return view("admin.categories.index", compact('categories'));
    }

    public function store(CategoriesRequest $request)
    {
        try {
            Category::create([
                'id' => Str::uuid(),
                'name' => $request->CreateCategoryName
            ]);

            return redirect()->route('categories.index')->with('success', 'Add category successfully.');

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput(request()->all)
                ->with('error', 'Add category failed.');
        }
    }

    public function update(CategoriesRequest $request, string $id)
    {
        try {
            Category::find($id)->update([
                'name' => $request->name
            ]);

            return response()->json(['success' => 'Update category successfully.', 'name' => $request->name]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Update category failed.']);

        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);

            DB::transaction(function () use ($category) {
                Product::where('category', $category->name)->update([
                    'category' => ''
                ]);
                $category->delete();
            });

            return response()->json(['success' => 'Delete category successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete category successfully.']);
        }
    }
}
