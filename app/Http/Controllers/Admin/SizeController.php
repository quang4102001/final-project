<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $sizes = Size::query();

        if ($request->SearchSizeName) {
            $sizes->where('name', 'LIKE', '%' . $request->SearchSizeName . '%');
        }
        if ($request->SearchMinHeight) {
            $sizes->where('minHeight', $request->SearchMinHeight);
        }
        if ($request->SearchMaxHeight) {
            $sizes->where('maxHeight', $request->SearchMaxHeight);
        }
        if ($request->SearchMinWeight) {
            $sizes->where('minWeight', $request->SearchMinWeight);
        }
        if ($request->SearchMaxWeight) {
            $sizes->where('maxWeight', $request->SearchMaxWeight);
        }

        $sizes = $sizes->paginate($request->pagination ?? config('admin.pagination', 50))->appends($request->all());

        return view("admin.sizes.index", compact('sizes'));
    }

    public function store(SizeRequest $request)
    {
        try {
            $params = $request->safe()->only(['name', 'minHeight', 'maxHeight', 'minWeight', 'maxWeight',]);
            $params = array_merge($params, ['id' => Str::uuid()]);

            Size::create($params);

            return redirect()->route('sizes.index')->with('success', 'Add size successfully.');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput($request->validated())
                ->with('error', 'Add size failed.');
        }
    }

    public function update(SizeRequest $request, string $id)
    {
        try {
            $params = $request->safe()->only(['name', 'minHeight', 'maxHeight', 'minWeight', 'maxWeight',]);

            Size::find($id)->update($params);

            return response()->json(['success' => 'Update size successfully.', 'params' => $params]);
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
            Log::info($e);
            return response()->json(['error' => 'Delete size successfully.']);
        }
    }
}
