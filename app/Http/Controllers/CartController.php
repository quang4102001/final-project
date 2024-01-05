<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
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
        $userId = auth()->id();
        $cartExists = Cart::where('user_id', $userId)->first();
        $cartDetails = $cartExists ? CartDetail::where('cart_id', $cartExists->id)->with(['color', 'product.images'])->get() : null;
        $cart = [];

        if ($cartDetails) {
            foreach ($cartDetails as $item) {
                $cart[] = [
                    'id' => $item->product_id ?? '',
                    'name' => $item->product->name ?? 'Tên sản phẩm',
                    'img' => $item->product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg',
                    'price' => $item->product->discounted_price ?? '9999',
                    'qty' => $item->qty ?? 0,
                    'colorId' => $item->colors->id ?? '',
                    'colorName' => $item->colors->name ?? '#fff'
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
            $userId = auth()->id();
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
                        CartDetail::updateOrCreate(
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
                    CartDetail::updateOrCreate(
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
            $userId = auth()->id();
            $cartExists = Cart::where('user_id', $userId)->first();
            $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                ->where('product_id', $request->productId)
                ->where('color_id', $request->colorId)
                ->first();

            if ($cartDetail) {
                DB::transaction(function () use ($request, $cartDetail) {
                    if ($cartDetail->qty > 1 && $request->type === 'except') {
                        $cartDetail->update(['qty' => DB::raw('qty - 1')]);
                    } else {
                        $cartDetail->delete();
                    }
                });
            } else {
                return response()->json(['success' => "Can't find cartDetail."]);
            }

            return response()->json(['success' => 'Delete from cart success.', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete from cart failed.', 'cart' => $this->getCartData()]);
        }
    }

    public function setToCart(Request $request)
    {
        try {
            $userId = auth()->id();
            $cartExists = Cart::where('user_id', $userId)->first();

            if ($cartExists) {
                DB::transaction(function () use ($request, $cartExists) {
                    $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                        ->where('product_id', $request->productId)
                        ->where('color_id', $request->colorId)->first();
                    if ($request->qty >= 1) {
                        $cartDetail->update(['qty' => $request->qty]);
                    } else {
                        $cartDetail->delete();
                    }
                });
            } else {
                return response()->json(['success' => "Can't find cartDetail."]);
            }

            return response()->json(['success' => 'Set quantity successfully.', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Set quantity failed.', 'cart' => $this->getCartData()]);
        }
    }

    public function checkCart(Request $request)
    {
        $cart = $request->cart;
        $cartId = array_column($cart, 'id');
        $products = Product::whereIn('id', $cartId)->get();
        //đánh dấu xem có thay đổi mảng cart không
        $check = false;

        // kiểm tra nếu 1 trong 2 mảng là rỗng thì return luôn
        if (!$products) {
            $check = true;
            return response()->json(['load' => $check, 'cart' => []]);
        }

        if (!$cart) {
            return response()->json(['load' => $check]);
        }

        foreach ($cart as $key => $item) {
            //đánh dấu xem sản phẩm này có còn tồn tại trong database không
            $isExistsInDatabase = false;

            foreach ($products as $product) {
                // Nếu id của 2 cái bằng nhau thì đánh dấu là có tồn tại trong database và kiểm tra status
                if ($item['id'] == $product->id) {
                    $isExistsInDatabase = true;
                    if ($product->status == 0) {
                        unset($cart[$key]);
                        $check = true;
                    }
                }
            }

            if (!$isExistsInDatabase) {
                unset($cart[$key]);
                $check = true;
            }
        }

        if (!$check) {
            return response()->json(['load' => $check]);
        }

        return response()->json(['load' => $check, 'cart' => $cart]);
    }

    public function removeByCheckCart(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                CartDetail::whereIn('product_id', $request->ids)->delete();
            });
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
