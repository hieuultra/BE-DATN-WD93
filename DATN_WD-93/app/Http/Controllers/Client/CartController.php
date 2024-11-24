<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VariantPackage;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function listCart(Request $request)
    {

        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $cart = Cart::where('user_id', Auth::id())->with("items.product", "items.variant")->first();
        // $cart = session()->get('cart', default: []);

        // $tt = $cart['price'] - (($cart['price']  * $cart['discount']) / 100);

        $total = 0;
        $subTotal = 0;
        $shipping = 40000;
        $discount = 0;
        if ($cart && $cart->items->count() > 0) {
            foreach ($cart->items as  $item) {
                $price = is_numeric($item['price']) ? $item['price'] : 0;
                $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
                // Kiểm tra nếu các khóa cần thiết tồn tại trong mục giỏ hàng
                // Tính toán tổng phụ
                $subTotal += $price * $quantity;
            }
        }
        // Xử lý mã giảm giá nếu có
        $checkTypeDiscount = 0;
        if ($request->has('coupon_code')) {
            if (request()->query('coupon_code') == 'loaibo') {
                $cart->coupon_code = null;
                $cart->save();
                $discount = 0;
            } else {
                $coupon = Coupon::where('code', $request->input('coupon_code'))->first();
                // dd($coupon->type);
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->value;
                    $cart->coupon_code = $coupon->code;
                    $cart->save();
                    if ($coupon->type == 'percentage') {
                        $checkTypeDiscount = 'percentage';
                    } else {
                        $checkTypeDiscount = 'fixed';
                    }
                } else {
                    return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
                }
            }
        }

        $total = $subTotal + $shipping - $discount;

        return view('client.home.cart', compact('orderCount', 'categories', 'cart', 'subTotal', 'shipping', 'total', 'discount', 'checkTypeDiscount'));
    }
    public function addCart(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $variantID = $request->input('variantId');
        $productId = $request->input('productId');

        try {
            if ($request->input('variantId')) {
                // dd($variantID,$productId);
                $variantProduct = VariantProduct::query()
                    ->where('id_product', $productId)
                    ->where('id_variant', $variantID)
                    ->firstOrFail();
                // dd($variantProduct);
                if (!$variantProduct) {
                    return redirect()->back()->with('error', "Sản phẩm không tồn tại");
                }
                // Tính toán giá sản phẩm sau khi áp dụng giảm giácod
                $totalPrice = $variantProduct->price - (($variantProduct->price * $variantProduct->product->discount) / 100);
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('variant_id', $variantProduct->id)
                    ->first();
                if ($cartItem) {
                    $cartItem->quantity += $request->quantity;
                    $cartItem->total = $totalPrice * $cartItem->quantity;
                    $cartItem->save(); //
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $variantProduct->product->id,
                        'variant_id' => $variantProduct->id,
                        'name' => $variantProduct->product->name,
                        'image' => $variantProduct->product->img,
                        'price' => $totalPrice,
                        'quantity' => $request->quantity,
                        'total' => $totalPrice * $request->quantity
                    ]);
                }
            } elseif ($request->input('productId')) {
                $product = Product::query()->findOrFail($productId);

                if (!$product) {
                    return redirect()->with('error', "Sản phẩm không tồn tại");
                }
                // Tính toán giá sản phẩm sau khi áp dụng giảm giácod
                $totalPrice = $product->price - (($product->price * $product->discount) / 100);

                // Check if the product is already in the cart
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($cartItem) {
                    // If the product already exists in the cart, update the quantity and total
                    $cartItem->quantity += $request->quantity; // Update quantity
                    $cartItem->total = $totalPrice * $cartItem->quantity; // Update total price
                    $cartItem->save(); // Save the updated item
                } else {
                    // If it doesn't exist, create a new cart item
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'name' => $product->name, // Store product name
                        'image' => $product->img, // Store product image
                        'price' => $totalPrice, // Store price after discount
                        'quantity' => $request->quantity, // Store quantity
                        'total' => $totalPrice * $request->quantity // Store total price
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!');
        }
    }
    public function updateCart(Request $request)
    {
        $items = $request->input('items');

        if (!$items || !is_array($items)) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
        }

        foreach ($items as $id => $item) {
            $quantity = $item['quantity'] ?? null;

            if (is_null($quantity) || !is_numeric($quantity)) {
                return response()->json(['message' => 'ID hoặc quantity không hợp lệ'], 400);
            }

            $cartItem = CartItem::findOrFail($id);
            $total = $cartItem->price * $quantity;

            // Cập nhật quantity và total
            $cartItem->update([
                'quantity' => $quantity,
                'total' => $total
            ]);
        }

        return response()->json(['message' => 'Giỏ hàng đã được cập nhật thành công'], 200);
    }


    public function removeCart(Request $request)
    {
        $cartItemId = $request->input('id');
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng']);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }
    public function reorder($orderId)
    {
        $order = Bill::with('products')->findOrFail($orderId);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($order->order_detail as $orderDetail) {
            // Lấy sản phẩm biến thể từ chi tiết đơn hàng
            $productVariant = VariantProduct::findOrFail($orderDetail->variant_id);

            // Tính toán giá sản phẩm biến thể sau khi áp dụng giảm giá
            $totalPrice = $productVariant->price - (($productVariant->price * $productVariant->discount) / 100);

            // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('variant_id', $productVariant->id) // Kiểm tra dựa trên `variant_id`
                ->first();

            if ($cartItem) {
                // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng và tổng giá
                $cartItem->quantity += $orderDetail->quantity; // Thêm số lượng theo đơn hàng trước đó
                $cartItem->total = $totalPrice * $cartItem->quantity; // Cập nhật tổng giá
                $cartItem->save();
            } else {
                // Nếu chưa có, tạo một mục giỏ hàng mới
                CartItem::create([
                    'cart_id' => $cart->id,
                    'variant_id' => $productVariant->id, // Lưu `variant_id`
                    'product_id' => $productVariant->id_product, // Liên kết tới sản phẩm chính
                    'name' => $productVariant->product->name,
                    'image' => $productVariant->product->img, // Ảnh từ sản phẩm biến thể
                    'price' => $totalPrice,
                    'quantity' => $orderDetail->quantity, // Số lượng theo đơn hàng trước đó
                    'total' => $totalPrice * $orderDetail->quantity
                ]);
            }
        }

        return redirect()->route('orders.index')->with('success', 'Các sản phẩm từ đơn hàng đã được thêm vào giỏ hàng.');
    }
    public function getPriceQuantiVariant(Request $request)
    {
        $namePakeges = $request->input('namePakeges'); //id san pham
        $idPakage = VariantPackage::where('name', $namePakeges)->select('id')->first();
        $idVp = $idPakage->id;
        if ($idVp) {
            $vp = VariantProduct::where('id_variant', $idVp)->select('quantity', 'price', 'id_variant')->first();
            return response()->json([
                'price' => number_format($vp->price, 0, ',', '.') . ' VNĐ',
                'quantity' => $vp->quantity,
                'id_variant' => $vp->id_variant,
            ]);
        }
        //not found
        return response()->json(['error' => 'Có lỗi đã xảy ra!!!'], 404);
    }
}
