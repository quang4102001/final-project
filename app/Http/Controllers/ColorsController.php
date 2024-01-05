<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ColorsController extends Controller
{
    const PAGINATION = 50;

    public function index(Request $request)
    {
        $colors = Color::query();

        if ($request->SearchColorName) {
            $colors->where('name', 'LIKE', '%' . $request->SearchColorName . '%');
        }

        $colors = $colors->paginate($request->pagination ?? static::PAGINATION)->appends($request->except('_token'));

        return view("admin.colors.index", compact('colors'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'CreateColorName' => 'required|unique:colors,name',
            ];

            $messages = [
                'CreateColorName.required' => 'Bắt buộc phải nhập trường mã màu.',
                'CreateColorName.unique' => 'Trùng mã màu.',
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
                Color::create([
                    'id' => Str::uuid(),
                    'name' => $request->CreateColorName
                ]);
            });

            return redirect()->route('colors.index')->with('success', 'Add color successfully.');

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput(request()->all)
                ->with('error', 'Add color failed.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'name' => 'required|unique:colors,name',
            ];

            $messages = [
                'name.required' => 'Bắt buộc phải nhập trường tên danh mục.',
                'name.unique' => 'Trùng tên danh mục.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return response()->json(['error' => 'Check your input.', 'validate' => $validator]);
            }

            DB::transaction(function () use ($request, $id) {
                Color::find($id)->update([
                    'name' => $request->name
                ]);
            });

            return response()->json(['success' => 'Update color successfully.', 'name' => $request->name]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Update color failed.']);

        }
    }

    public function destroy(string $id)
    {
        try {
            $color = Color::with('cartDetails')->find($id);

            DB::transaction(function () use ($color) {
                $color->cartDetails()->delete();
                $color->products()->detach();
                $color->delete();
            });

            return response()->json(['success' => 'Delete color successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete color successfully.']);
        }
    }
}
