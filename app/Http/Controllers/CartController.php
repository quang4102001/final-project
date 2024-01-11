<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $sessionKeyCart = 'cart';

    public function addToCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $colorId = $request->colorId;
            $sessionCartId = $productId . $colorId;

            if (auth()->check()) {
                $this->sessionKeyCart = "cartUser";
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

            $cart = Session::get($this->sessionKeyCart, []);
            // đã tồn tại trong giỏ hàng
            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                $cart[$sessionCartId]['qty'] += 1;

                Session::put($this->sessionKeyCart, $cart);
                return response()->json(['success' => 'Add to cart successfully.']);
            }

            // chưa tồn tại trong giỏ hàng
            $product = Product::find($productId);
            $color = Color::find($colorId);
            if (!($product && $color)) {
                return response()->json(['success' => "Do not find product or color."]);
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

            Session::put($this->sessionKeyCart, $cart);
            Log::info(Session::get($this->sessionKeyCart));
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
                $this->sessionKeyCart = "cartUser";
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

            $cart = Session::get($this->sessionKeyCart, []);
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
            Session::put($this->sessionKeyCart, $cart);
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
                $this->sessionKeyCart = "cartUser";
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

            $cart = Session::get($this->sessionKeyCart, []);
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

            Session::put($this->sessionKeyCart, $cart);
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
                $this->sessionKeyCart = "cartUser";
                $userId = auth()->id();
                $cartExists = Cart::where('user_id', $userId)->first();

                CartDetail::where('cart_id', $cartExists->id)
                    ->where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->delete();
            }

            $cart = Session::get($this->sessionKeyCart, []);
            if (!$cart) {
                return response()->json(['error' => "Cart is empty."]);
            }

            if (isset($cart[$sessionCartId]) && $cart[$sessionCartId]['productId'] == $productId && $cart[$sessionCartId]['colorId'] == $colorId) {
                unset($cart[$sessionCartId]);
            }

            Session::put($this->sessionKeyCart, $cart);
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

    public function checkSessionCart()
    {
        if (auth()->check()) {
            $this->sessionKeyCart = 'cartUser';
        }
        $cart = Session::get($this->sessionKeyCart);
        $cartIds = $cart ? array_column($cart, 'productId') : [];
        $products = Product::whereIn('id', $cartIds)->where('status', 1)->get();
        //đánh dấu xem có thay đổi mảng cart không
        $check = false;

        // kiểm tra nếu 1 trong 2 mảng là rỗng thì return luôn
        if (!$products) {
            $check = true;
            Session::put($this->sessionKeyCart, []);
            return response()->json(['load' => $check]);
        }

        if (!$cart) {
            Session::put($this->sessionKeyCart, []);
            return response()->json(['load' => $check]);
        }

        foreach ($cart as $key => $item) {
            //đánh dấu xem sản phẩm này có còn tồn tại trong mối quan hệ không
            $isExistsInProducts = false;
            $isExistsInColors = false;

            foreach ($products as $product) {
                // Nếu id của 2 cái bằng nhau thì đánh dấu là có tồn tại trong database và kiểm tra status
                if ($item['productId'] == $product->id) {
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
            Session::put($this->sessionKeyCart, $cart);
            return response()->json(['load' => $check]);
        }
        Session::put($this->sessionKeyCart, $cart);
        return response()->json(['load' => $check]);
    }

    public function checkDatabaseCart()
    {
        try {
            $userId = auth()->id();
            $cartExists = Cart::where('user_id', $userId)->first();
            if (!$cartExists) {
                return response()->json(['info', 'Cart do not exists.']);
            }

            $cartDetails = CartDetail::where('cart_id', $cartExists->id)->get();
            if ($cartDetails->isEmpty()) {
                return response()->json(['info', 'Cart is empty.']);
            }
            $productCartIds = $cartDetails ? $cartDetails->pluck('product_id')->all() : [];

            $products = Product::whereIn('id', $productCartIds)->where('status', 1)->get();
            if ($products->isEmpty()) {
                return response()->json(['info', 'Cart to empty array.']);
            }

            DB::transaction(function () use ($cartDetails, $products) {
                foreach ($cartDetails as $item) {
                    if (!$products->pluck('id')->contains($item->product_id)) {
                        $item->delete();
                        continue;
                    }
                    $isColorExistInProduct = $products->contains(function ($product) use ($item) {
                        return $product->id == $item->product_id && $product->colors->pluck('id')->contains($item->color_id);
                    });
                    if (!$isColorExistInProduct) {
                        $item->delete();
                    }
                }
            });

            return response()->json(['info', 'Check cart successfully.']);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['info', 'Check cart failed.']);
        }
    }
}
