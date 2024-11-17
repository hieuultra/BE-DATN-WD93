<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Cart;
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
    public function listCart()
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

        return view('client.home.cart', compact('orderCount', 'categories', 'cart', 'subTotal', 'shipping', 'total'));
    }
    public function addCart(Request $request)
    {
        $id_variant = $request->input('variant_id');
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $productId = $request->input('productId');
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
                'variant_id' => $id_variant,
                'name' => $product->name, // Store product name
                'image' => $product->img, // Store product image
                'price' => $totalPrice, // Store price after discount
                'quantity' => $request->quantity, // Store quantity
                'total' => $totalPrice * $request->quantity // Store total price
            ]);
        }
        return redirect()->back();
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

        foreach ($order->products as $product) {
            // Tính toán giá sản phẩm sau khi áp dụng giảm giá
            $totalPrice = $product->price - (($product->price * $product->discount) / 100);

            // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng và tổng giá
                $cartItem->quantity += 1; // có thể điều chỉnh số lượng tùy ý
                $cartItem->total = $totalPrice * $cartItem->quantity; // Cập nhật tổng giá
                $cartItem->save();
            } else {
                // Nếu chưa có, tạo một mục giỏ hàng mới
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->img,
                    'price' => $totalPrice,
                    'quantity' => 1, // có thể đặt lại số lượng mặc định
                    'total' => $totalPrice
                ]);
            }
        }

        return redirect()->route('orders.index')->with('success', 'Các sản phẩm từ đơn hàng đã được thêm vào giỏ hàng.');
    }
    public function getPriceQuantiVariant(Request $request){
        $namePakeges = $request->input('namePakeges'); //id san pham
        $idPakage = VariantPackage::where('name',$namePakeges)->select('id')->first(); 
        $idVp = $idPakage->id;
        if ($idVp) {
            $vp = VariantProduct::where('id_variant', $idVp)->select('quantity', 'price','id_variant')->first();
            return response()->json([
                'price'=>number_format($vp->price, 0, ',', '.') . ' VNĐ',
                'quantity'=>$vp->quantity,
                'id_variant'=>$vp->id_variant,
            ]);
        }    
        //not found
        return response()->json(['error'=>'Có lỗi đã xảy ra!!!'], 404);
    }
}
