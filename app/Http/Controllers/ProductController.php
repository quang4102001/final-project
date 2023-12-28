<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = new Product();
        if ($request->input('SearchProductName') != '') {
            $products = $products->where('name', 'LIKE', '%'.$request->input('SearchProductName').'%');
        }
        if ($request->input('SearchCategoryId') != '') {
            $products = $products->where('category', $request->input('SearchCategoryId'));
        }
        if ($request->input('SearchStatusId') != '') {
            $products = $products->where('status', $request->input('SearchStatusId'));
        }
        if ($request->input('SearchPriceMin') != '') {
            $products = $products->where('price', $request->input('SearchPriceMin'));
        }
        if ($request->input('SearchPriceMax') != '') {
            $products = $products->where('price', $request->input('SearchPriceMax'));
        }
        $products = $products->all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->input('name'),
                    'sku' => $request->input('sku'),
                    'price' => $request->input('price'),
                    'discounted_price' => $request->input('discounted_price'),
                    'category' => $request->input('category'),
                    'status' => '1',
                ]);

                $product->colors()->attach($request->input('colors'));
                $product->images()->attach($request->input('images'));
                $product->sizes()->attach($request->input('sizes'));
            });
            return redirect()->route('product.index')->with('success', 'Products created successfully');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withInput(request()->all())
                ->with('error', 'Add product failed!');
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $product = Product::with(['colors', 'images', 'sizes'])->find($id);
            $images = Image::all();
            $productColors = [];
            $productSizes = [];
            $productImages = [];

            foreach ($product->colors as $color) {
                $productColors[] = $color->id;
            }
            foreach ($product->sizes as $size) {
                $productSizes[] = $size->id;
            }
            foreach ($product->images as $image) {
                $productImages[] = $image->id;
            }

            return view('products.edit', compact('id', 'product', 'images', 'productColors', 'productSizes', 'productImages'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withInput(request()->all())
                ->with('error', 'Error go to edit product: ' . $e->getMessage() . ' ' . $e->getLine());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        //
        try {
            DB::transaction(function () use ($request, $id) {

                $product = Product::findOrFail($id);

                $product->update([
                    'name' => $request->input('name'),
                    'sku' => $request->input('sku'),
                    'price' => $request->input('price'),
                    'discounted_price' => $request->input('discounted_price'),
                    'category' => $request->input('category'),
                    'status' => '1',
                ]);

                $product->colors()->sync($request->input('colors', []));
                $product->images()->sync($request->input('images', []));
                $product->sizes()->sync($request->input('sizes', []));
            });
            return redirect()->route('product.index')->with('success', 'Product update successfully');

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withInput(request()->all())
                ->with('error', 'Error update product: ' . $e->getMessage() . ' ' . $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            DB::transaction(function () use ($id) {
                $product = Product::with(['colors', 'images', 'sizes'])->find($id);

                if (!$product) {
                    return response()->json(['error' => 'Product not found.'], 404);
                }

                $product->delete();
            });

            return response()->json(['success'=> 'Deleted product successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withInput(request()->all())
                ->with('error', 'Error delete product: ' . $e->getMessage() . ' ' . $e->getLine());
        }
    }

}
