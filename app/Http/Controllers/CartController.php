<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $sessionKey = 'cart';

    public function addToCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $colorId = $request->colorId;
            $sessionCartId = $productId . $colorId;

            if (auth()->check()) {
                $this->sessionKey = "cartUser";
                $userId = auth()->id();
                $cartExists = Cart::where('user_id', $userId)->first();

                if (!$cartExists) {
                    $cartId = Str::uuid();

                    $cartExists = Cart::create([
                        'id' => $cartId,
                        'user_id' => $userId,
                    ]);
                }
                CartDetail::updateOrCreate(
                    [
                        'cart_id' => $cartExists->id,
                        'product_id' => $productId,
                        'color_id' => $colorId,
                    ],
                    [
                        'qty' => DB::raw('qty + 1'),
                    ]
                );
            }

            $cart = Session::get($this->sessionKey, []);
            // đã tồn tại trong giỏ hàng
            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                $cart[$sessionCartId]['qty'] += 1;

                Session::put($this->sessionKey, $cart);
                return response()->json(['success' => 'Add to cart successfully.']);
            }

            // chưa tồn tại trong giỏ hàng
            $product = Product::find($productId);
            $color = Color::find($colorId);
            if (!($product && $color)) {
                return response()->json(['error' => "Do not find product or color."]);
            }

            $cart[$sessionCartId] = [
                'productId' => $productId ?? null,
                'name' => $product->name ?? "Lỗi tên",
                'img' => $product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg',
                'price' => $product->discounted_price ?? 0,
                'qty' => 1,
                'colorId' => $colorId ?? null,
                'colorName' => $color->name ?? "white",
            ];

            Session::put($this->sessionKey, $cart);
            Log::info(Session::get($this->sessionKey));
            return response()->json(['success' => 'Add to cart successfully.']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e]);
        }
    }

    public function exceptFromCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $colorId = $request->colorId;
            $sessionCartId = $productId . $colorId;

            if (auth()->check()) {
                $this->sessionKey = "cartUser";
                $userId = auth()->id();
                $cartExists = Cart::where('user_id', $userId)->first();

                $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                    ->where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->first();

                if ($cartDetail) {
                    if ($cartDetail->qty > 1) {
                        $cartDetail->update(['qty' => DB::raw('qty - 1')]);
                    } else {
                        $cartDetail->delete();
                    }
                } else {
                    return response()->json(['error' => 'Can not find cart detail.']);
                }
            }

            $cart = Session::get($this->sessionKey, []);
            if (!$cart) {
                return response()->json(['error' => "Cart is empty."]);
            }

            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                if ($cart[$sessionCartId]['qty'] > 1) {
                    $cart[$sessionCartId]['qty'] -= 1;
                } else {
                    unset($cart[$sessionCartId]);
                }
            }

            Log::info($cart);
            Session::put($this->sessionKey, $cart);
            return response()->json(['success' => 'Except product successfully']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e]);
        }
    }

    public function setToCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $colorId = $request->colorId;
            $sessionCartId = $productId . $colorId;
            $qty = $request->qty;

            if (auth()->check()) {
                $this->sessionKey = "cartUser";
                $userId = auth()->id();
                $cartExists = Cart::where('user_id', $userId)->first();
                $cartDetail = CartDetail::where('cart_id', $cartExists->id)
                    ->where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->first();

                if ($cartDetail) {
                    if ($qty >= 1) {
                        $cartDetail->update(['qty' => $qty]);
                    } else {
                        $cartDetail->delete();
                    }
                } else {
                    return response()->json(['success' => "Can't find cartDetail."]);
                }
            }

            $cart = Session::get($this->sessionKey, []);
            if (!$cart) {
                return response()->json(['error' => "Cart is empty."]);
            }

            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                if ($qty >= 1) {
                    $cart[$sessionCartId]['qty'] = $qty;
                } else {
                    unset($cart[$sessionCartId]);
                }
            }

            Session::put($this->sessionKey, $cart);
            return response()->json(['success' => 'Set quantity successfully']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e]);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $colorId = $request->colorId;
            $sessionCartId = $productId . $colorId;

            if (auth()->check()) {
                $this->sessionKey = "cartUser";
                $userId = auth()->id();
                $cartExists = Cart::where('user_id', $userId)->first();

                CartDetail::where('cart_id', $cartExists->id)
                    ->where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->delete();
            }

            $cart = Session::get($this->sessionKey, []);
            if (!$cart) {
                return response()->json(['error' => "Cart is empty."]);
            }

            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                unset($cart[$sessionCartId]);
            }

            Session::put($this->sessionKey, $cart);
            return response()->json(['success' => 'Remove from cart successfully']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e]);
        }
    }

    public function mergeCartWithDatabase()
    {
        try {
            $cartId = Str::uuid();
            $userId = auth()->id();
            $cartExists = Cart::where('user_id', $userId)->first();

            if (!$cartExists) {
                $cartExists = Cart::create([
                    'id' => $cartId,
                    'user_id' => $userId,
                ]);
            }

            if (Session::has('cart')) {
                $sessionCart = Session::get('cart') ?? [];

                DB::transaction(function () use ($sessionCart, $cartExists) {
                    foreach ($sessionCart as $item) {
                        CartDetail::updateOrCreate(
                            [
                                'cart_id' => $cartExists->id,
                                'product_id' => $item['productId'],
                                'color_id' => $item['colorId'],
                            ],
                            [
                                'qty' => DB::raw('qty + ' . $item['qty']),
                            ]
                        );
                    }
                });
                Session::forget('cart');
            }

            //Gán lại giỏ hàng đã được cập nhật vào session
            $newCart = [];
            $dataCart = CartDetail::with('product.images')->where('cart_id', $cartExists->id)->get();
            foreach ($dataCart as $item) {
                $newCartId = $item->product_id . $item->color_id;

                $newCart[$newCartId] = [
                    'productId' => $item->product_id ?? null,
                    'name' => $item->product->name ?? 'Lỗi tên',
                    'img' => $item->product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg',
                    'price' => $item->product->discounted_price ?? 0,
                    'qty' => $item->qty ?? 0,
                    'colorId' => $item->color_id ?? null,
                    'colorName' => $item->color->name ?? 'white'
                ];
            }

            Session::put('cartUser', $newCart ?? []);
            Log::info(Session::get('cartUser'));
            return response()->json(['info' => 'merge cart with database successfully.']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e]);
        }
    }

    // --------------------------------------------------------------------------------------
    public function getCartData()
    {
        $userId = auth()->id();
        $cartExists = Cart::where('user_id', $userId)->first();
        $cartDetails = $cartExists ? CartDetail::where('cart_id', $cartExists->id)->with(['color', 'product.images'])->get() : null;
        $cart = [];

        if ($cartDetails) {
            foreach ($cartDetails as $item) {
                $cart[] = [
                    'id' => $item->product_id ?? null,
                    'name' => $item->product->name ?? null,
                    'img' => $item->product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg',
                    'price' => $item->product->discounted_price ?? 0,
                    'qty' => $item->qty ?? 0,
                    'colorId' => $item->color->id ?? null,
                    'colorName' => $item->color->name ?? null
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

    public function checkCart(Request $request)
    {
        $cart = $request->cart;
        $cartId = $cart ? array_column($cart, 'id') : [];
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
            //đánh dấu xem sản phẩm này có còn tồn tại trong mối quan hệ không
            $isExistsInProducts = false;
            $isExistsInColors = false;

            foreach ($products as $product) {
                // Nếu id của 2 cái bằng nhau thì đánh dấu là có tồn tại trong database và kiểm tra status
                if ($item['id'] == $product->id) {
                    $isExistsInProducts = true;
                    if ($product->status == 0) {
                        unset($cart[$key]);
                        $check = true;
                    }
                    if (!$product->colors) {
                        unset($cart[$key]);
                        $check = true;
                    }
                    foreach ($product->colors as $color) {
                        if ($color->id == $item['colorId']) {
                            $isExistsInColors = true;
                        }
                    }
                }
            }
            if (!$isExistsInProducts) {
                unset($cart[$key]);
                $check = true;
            }
            if (!$isExistsInColors) {
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
            if ($request->ids) {
                CartDetail::whereIn('product_id', $request->ids)->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
