<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

        $categories = $categories->paginate($request->pagination ?? static::PAGINATION)->appends($request->except('_token'));

        return view("admin.categories.index", compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'CreateCategoryName' => 'required|min:3|max:255|unique:categories,name',
            ];

            $messages = [
                'CreateCategoryName.required' => 'Bắt buộc phải nhập trường tên danh mục.',
                'CreateCategoryName.min' => 'Nhập ít nhất :min kí tự.',
                'CreateCategoryName.max' => 'Nhập nhiều nhất :max kí tự.',
                'CreateCategoryName.unique' => 'Trùng tên danh mục.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Check your input.');
            }

            DB::transaction(function () use ($request) {
                Category::create([
                    'id' => Str::uuid(),
                    'name' => $request->CreateCategoryName
                ]);
            });

            return redirect()->route('categories.index')->with('success', 'Add category successfully.');

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput(request()->all)
                ->with('error', 'Add category failed.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'name' => 'required|min:3|max:255|unique:categories,name',
            ];

            $messages = [
                'name.required' => 'Bắt buộc phải nhập trường tên danh mục.',
                'name.min' => 'Nhập ít nhất :min kí tự.',
                'name.max' => 'Nhập nhiều nhất :max kí tự.',
                'name.unique' => 'Trùng tên danh mục.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => 'Check your input.', 'validate' => $validator]);
            }

            DB::transaction(function () use ($request, $id) {
                Category::find($id)->update([
                    'name' => $request->name
                ]);
            });

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

            DB::transaction(function() use ($category){
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
