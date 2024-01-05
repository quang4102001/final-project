<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SizesController extends Controller
{
    const PAGINATION = 50;

    public function index(Request $request)
    {
        $sizes = Size::query();

        if ($request->SearchSizeName) {
            $sizes->where('name', 'LIKE', '%' . $request->SearchSizeName . '%');
        }

        $sizes = $sizes->paginate($request->pagination ?? static::PAGINATION)->appends($request->except('_token'));

        return view("admin.sizes.index", compact('sizes'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'CreateSizeName' => 'required|min:1|max:255|unique:sizes,name',
            ];

            $messages = [
                'CreateSizeName.required' => 'Bắt buộc phải nhập trường tên danh mục.',
                'CreateSizeName.min' => 'Nhập ít nhất :min kí tự.',
                'CreateSizeName.max' => 'Nhập nhiều nhất :max kí tự.',
                'CreateSizeName.unique' => 'Trùng tên danh mục.',
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
                Size::create([
                    'id' => Str::uuid(),
                    'name' => $request->CreateSizeName
                ]);
            });

            return redirect()->route('sizes.index')->with('success', 'Add size successfully.');

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput(request()->all)
                ->with('error', 'Add size failed.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'name' => 'required|min:3|max:255|unique:sizes,name',
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
                Size::find($id)->update([
                    'name' => $request->name
                ]);
            });

            return response()->json(['success' => 'Update size successfully.', 'name' => $request->name]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Update size failed.']);

        }
    }

    public function destroy(string $id)
    {
        try {
            $size = Size::find($id);
            DB::transaction(function () use ($size) {
                $size->products()->detach();
                $size->delete();
            });

            return response()->json(['success' => 'Delete size successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete size successfully.']);
        }
    }
}
