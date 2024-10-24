<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class CartController extends Controller
{
    public function list()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $cart = Cart::where('user_id', Auth::id())->with("items.product", "items.variant")->first();

        // $tt = $cart['price'] - (($cart['price']  * $cart['discount']) / 100);

        $total = 0;
        $subTotal = 0;
        $shipping = 50;
        if ($cart && $cart->items->count() > 0) {
            foreach ($cart->items as  $item) {
                $price = is_numeric($item['price']) ? $item['price'] : 0;
                $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
                // Kiểm tra nếu các khóa cần thiết tồn tại trong mục giỏ hàng

                // Tính toán tổng phụ
                $subTotal += $price * $quantity;
            }
            $total = $subTotal + $shipping;
        }
        return view('client.home.cart', compact('categories', 'cart', 'subTotal', 'shipping', 'total'));
    }
    public function add(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $productId = $request->input('productId');
        // $variantId = $request->input('variantId');
        $quantity = $request->input('quantity');

        $product = Product::query()->findOrFail($productId);
        // $variant = VariantProduct::query()->findOrFail($variantId);
        if (!$product) {
            return redirect()->with('error', "Sản phẩm không tồn tại");
        }
        // Tính toán giá sản phẩm sau khi áp dụng giảm giácod
        $totalPrice = $product->price - (($product->price * $product->discount) / 100);

        CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                // 'variant_id' => $variant->id
            ],
            [
                'name' => $product->name, // Lưu tên sản phẩm vào cart_items
                'image' => $product->img, // Lưu tên sản phẩm vào cart_items
                'price' => $totalPrice,    // Lưu giá của sản phẩm vào cart_items
                'quantity' => $request->quantity,
                'total' => $totalPrice * $request->quantity
            ]
        );

        return redirect()->back();
    }
    public function update(Request $request)
    {
        $cartItemId = $request->input('id');
        $quantity = $request->input('quantity');
        
        $cartItem = CartItem::query()->findOrFail($cartItemId);
        $total = $cartItem->price * $quantity;
        
        $param['quantity'] = $quantity;
        $param['total'] = $total;

        $cartItem->update($param);
        // Trả về phản hồi thành công
        return response()->json(['message' => 'Giỏ hàng đã được cập nhật thành công'], 200);
    }
    public function remove(Request $request)
    {
        $cartItemId = $request->input('id');
        $cartItem = CartItem::query()->find($cartItemId);
        $cartItem->delete();
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng']);
    }
}