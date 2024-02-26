<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        if ($request->SearchCategoryName) {
            $categories->where('name', 'LIKE', '%' . $request->SearchCategoryName . '%');
        }

        $categories = $categories->paginate($request->pagination ?? config('admin.pagination', 50))->appends($request->all());

        return view("admin.categories.index", compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            Category::create([
                'id' => Str::uuid(),
                'name' => $request->safe()->name
            ]);

            return redirect()->route('categories.index')->with('success', 'Add category successfully.');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput($request->validated())
                ->with('error', 'Add category failed.');
        }
    }

    public function update(CategoryRequest $request, string $id)
    {
        try {
            Category::find($id)->update([
                'name' => $request->safe()->name
            ]);

            return response()->json(['success' => 'Update category successfully.', 'name' => $request->safe()->name]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Update category failed.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            Category::find($id)->delete();

            return response()->json(['success' => 'Delete category successfully.']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Delete category successfully.']);
        }
    }
}
