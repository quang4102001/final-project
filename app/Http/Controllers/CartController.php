<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    //
    public function getCartData()
    {
        $userId = auth()->user()->id;
        $cartExists = Cart::where('user_id', $userId)->first();
        $cartDetails = CartDetail::where('cart_id', $cartExists->id)->with(['colors', 'product.images'])->get();
        $cart = [];
        if ($cartDetails) {
            foreach ($cartDetails as $item) {
                $cart[] = [
                    'id' => $item->product_id,
                    'name' => $item->product->name,
                    'img' => $item->product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg',
                    'price' => $item->product->price,
                    'qty' => $item->qty,
                    'colorId' => $item->colors->id,
                    'colorName' => $item->colors->name
                ];
            }
        }
        return $cart;
    }

    public function cartDataToView()
    {
        $cart = $this->getCartData();
        return response()->json(['cart' => $cart]);
    }

    public function addToCart(Request $request)
    {
        Log::info($request);
        try {
            $userId = auth()->user()->id;
            $cartId = Str::uuid();
            $cartExists = Cart::where('user_id', $userId)->first();

            DB::transaction(function () use ($request, $cartExists, $cartId, $userId) {

                if (!$cartExists) {
                    $cartExists = Cart::create([
                        'id' => $cartId,
                        'user_id' => $userId,
                    ]);
                }
                if ($request->type == 'many') {
                    foreach ($request->cart as $item) {
                        $cartDetail = CartDetail::updateOrCreate(
                            [
                                'cart_id' => $cartExists->id,
                                'product_id' => $item['id'],
                                'color_id' => $item['colorId'],
                            ],
                            [
                                'qty' => DB::raw('qty + ' . $item['qty']),
                            ]
                        );
                    }
                } else {
                    $cartDetail = CartDetail::updateOrCreate(
                        [
                            'cart_id' => $cartExists->id,
                            'product_id' => $request->productId,
                            'color_id' => $request->colorId,
                        ],
                        [
                            'qty' => DB::raw('qty + 1'),
                        ]
                    );
                }
            });
            Cookie::queue(Cookie::forget('cart'));
            return response()->json(['success' => 'Add to cart successfully.', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => 'Add to cart failed.', 'cart' => $this->getCartData()]);
        }
    }

    public function exceptFromCart(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $cartExists = Cart::where('user_id', $userId)->first();
            $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                ->where('product_id', $request->productId)
                ->where('color_id', $request->colorId)->first();
            DB::transaction(function () use ($request, $cartDetail) {
                if ($cartDetail->qty > 1 & $request->type === 'except') {
                    $cartDetail->update(['qty' => DB::raw('qty - 1')]);
                } else {
                    $cartDetail->delete();
                }
            });
            return response()->json(['success' => 'Delete from cart success.', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete from cart failed.', 'cart' => $this->getCartData()]);
        }
    }

    public function setToCart(Request $request)
    {
        Log::info($request);
        try {
            $userId = auth()->user()->id;
            $cartExists = Cart::where('user_id', $userId)->first();
            DB::transaction(function () use ($request, $cartExists) {
                if ($cartExists) {
                    $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                        ->where('product_id', $request->productId)
                        ->where('color_id', $request->colorId)->first();
                    if ($request->qty >= 1) {
                        $cartDetail->update(['qty' => $request->qty]);
                    } else {
                        $cartDetail->delete();
                    }
                }
            });
            return response()->json(['success' => 'Set quantity successfully.', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Set quantity failed.', 'cart' => $this->getCartData()]);
        }
    }

    public function checkCart(Request $request){
        
    }

}
