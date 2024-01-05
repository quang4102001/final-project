<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{
    public function destroyManyProducts(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->ids) {
                    $products = Product::whereIn('id', $request->ids);
                    $products->sizes()->detach();
                    $products->colors()->detach();
                    $products->images()->detach();
                    $products->cartDetails()->delete();
                }

            });

            return response()->json(['success' => 'Delete selected products successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Delete selected products failed.']);
        }
    }

    public function destroyManyCategories(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->ids) {
                    $categories = Category::whereIn('id', $request->ids)->get();

                    foreach ($categories as $category) {
                        Product::where('category', $category->name)->update([
                            'category' => ''
                        ]);
                    }

                    Category::whereIn('id', $request->ids)->delete();
                }

            });

            return response()->json(['success' => 'Delete selected categories successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Delete selected categories failed.']);
        }
    }

    public function destroyManyColors(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->ids) {
                    $colors = Color::whereIn('id', $request->ids);

                    foreach ($colors as $color) {
                        $color->cartDetails()->delete();
                        $color->products()->detach();
                    }

                    $colors->delete();
                }

            });

            return response()->json(['success' => 'Delete selected colors successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Delete selected colors failed.']);
        }
    }

    public function destroyManySizes(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->ids) {
                    $sizes = Size::whereIn('id', $request->ids);

                    foreach ($sizes as $size) {
                        $size->products()->detach();
                    }

                    $sizes->delete();
                }
            });

            return response()->json(['success' => 'Delete selected sizes successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Delete selected sizes failed.']);
        }
    }

    public function destroyManyImages(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->ids) {
                    $images = Image::whereIn('id', $request->ids);

                    foreach ($images as $image) {
                        $image->products()->detach();
                        $url = str_replace('/storage', 'public', $image->path);
                        Storage::delete($url);
                    }

                    $images->delete();
                }
            });

            return response()->json(['success' => 'Delete selected images successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Delete selected images failed.']);
        }
    }
}
