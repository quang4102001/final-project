<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = Color::query();

        if ($request->SearchColorName) {
            $colors->where('name', 'LIKE', '%' . $request->SearchColorName . '%');
        }

        $colors = $colors->paginate($request->pagination ?? config('admin.pagination', 50))->appends($request->all());

        return view("admin.colors.index", compact('colors'));
    }

    public function store(ColorRequest $request)
    {
        try {
            Color::create([
                'id' => Str::uuid(),
                'name' => $request->safe()->name
            ]);

            return redirect()->route('colors.index')->with('success', 'Add color successfully.');

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput($request->validated())
                ->with('error', 'Add color failed.');
        }
    }

    public function update(ColorRequest $request, string $id)
    {
        try {
            Color::find($id)->update([
                'name' => $request->safe()->name
            ]);

            return response()->json(['success' => 'Update color successfully.', 'name' => $request->safe()->name]);
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
            Log::info($e);
            return response()->json(['error' => 'Delete color successfully.']);
        }
    }
}
