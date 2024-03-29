<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    const PAGINATION = 50;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->SearchProductName) {
            $products->where('name', 'LIKE', '%' . $request->SearchProductName . '%');
        }
        if ($request->SearchCategory) {
            $products->where('category_id', $request->SearchCategory);
        }
        if ($request->SearchStatusId != '') {
            $products->where('status', $request->SearchStatusId);
        }
        if ($request->SearchPriceMin) {
            $products->where('price', '>=', $request->SearchPriceMin);
        }
        if ($request->SearchPriceMax) {
            $products->where('price', '<=', $request->SearchPriceMax);
        }
        if ($request->pagination) {
            $pagination = $request->pagination;
        }

        $products = $products->paginate($pagination ?? static::PAGINATION)->appends($request->all());

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $images = Image::doesntHave('products')->get();
        return view('admin.products.create', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $params = $request->only(['name', 'sku', 'price', 'discounted_price', 'category_id']);
        $params = array_merge($params, ['status' => '1']);

        try {
            DB::transaction(function () use ($request, $params) {
                $product = Product::create($params);
                $product->colors()->attach($request->colors);
                $product->images()->attach($request->images);
                $product->sizes()->attach($request->sizes);
            });

            return redirect()->route('product.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()
                ->back()
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
        try {
            $product = Product::find($id);
            $images = Image::doesntHave('products')->get();
            $productColorIds = $product->colors->pluck('id')->all();
            $productSizeIds = $product->sizes->pluck('id')->all();

            return view('admin.products.edit', compact('id', 'product', 'images', 'productColorIds', 'productSizeIds'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()
                ->back()
                ->withInput(request()->all())
                ->with('error', 'Error go to edit product: ' . $e->getMessage() . ' ' . $e->getLine());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $params = $request->only(['name', 'sku', 'price', 'discounted_price', 'category_id']);

            $product = Product::find($id);
            DB::transaction(function () use ($request, $params, $product) {
                $product->update($params);
                $product->colors()->sync($request->input('colors', []));
                $product->images()->sync($request->input('images', []));
                $product->sizes()->sync($request->input('sizes', []));
            });
            return redirect()->route('product.index')->with('success', 'Product update successfully');

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()
                ->back()
                ->withInput(request()->all())
                ->with('error', 'Product update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $product = Product::find($id);
                $product->colors()->detach();
                $product->sizes()->detach();
                $product->images()->detach();
                $product->cartDetails()->delete();
                $product->delete();
            });

            if ($request->ajax()) {
                return response()->json(['success' => 'Deleted product successfully.']);
            }

            return redirect()->route('product.index')->with('success', 'Deleted product successfully.');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()
                ->back()
                ->withInput(request()->all())
                ->with('error', 'Error delete product: ' . $e->getMessage() . ' ' . $e->getLine());
        }
    }

    public function productDetail(string $id)
    {
        try {
            $product = Product::find($id);
            $products = Product::where('id', '!=', $id)->limit(4);

            if (auth('admin')->check()) {
                $products = $products->get();

                return view('admin.productDetail', compact('products', 'product'));
            } else {
                $products = $products->where('status', 1)->get();

                return view('home.productDetail', compact('product', 'products'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something failed.");
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            Product::find($id)->update([
                'status' => $request->input('status'),
            ]);

            return response()->json(['success' => 'Update status successfully']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Update status failed!']);
        }
    }

}
