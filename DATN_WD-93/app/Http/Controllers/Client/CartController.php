<?php

namespace App\Http\Controllers\Client;

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VariantProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function listCart()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $cart = Cart::where('user_id', Auth::id())->with("items.product", "items.variant")->first();
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
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
        return view('client.home.cart', compact('orderCount','categories', 'cart', 'subTotal', 'shipping', 'total'));
    }
    public function addCart(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $productId = $request->input('productId');
        // $variantId = $request->input('variantId');
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
    public function updateCart(Request $request)
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
    public function removeCart(Request $request)
    {
        $cartItemId = $request->input('id');
        $cartItem = CartItem::query()->find($cartItemId);
        $cartItem->delete();
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng']);
    }
}
// class CartController extends Controller
// {
//     public function listCart()
//     {
//         $categories = Category::orderBy('name', 'asc')->get();
//         $orderCount = 0; // Mặc định nếu chưa đăng nhập
//         if (Auth::check()) {
//             $user = Auth::user();
//             $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
//         }
//         $cart = session()->get('cart', default: []);

//         // $tt = $cart['price'] - (($cart['price']  * $cart['discount']) / 100);

//         $total = 0;
//         $subTotal = 0;
//         foreach ($cart as $item) {
//             // Kiểm tra giá và số lượng có phải là số không
//             $price = is_numeric($item['price']) ? $item['price'] : 0;
//             $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
//             // Kiểm tra nếu các khóa cần thiết tồn tại trong mục giỏ hàng

//             // Tính toán tổng phụ
//             $subTotal += $price * $quantity;
//         }
//         $shipping = 50;
//         $total = $subTotal + $shipping;

//         return view('client.home.cart', compact('orderCount','categories', 'cart', 'subTotal', 'shipping', 'total'));
//     }
//     public function addCart(Request $request)
//     {
//         $categories = Category::orderBy('name', 'asc')->get();
//         $productId = $request->input('productId');
//         $quantity = $request->input('quantity');

//         $product = Product::query()->findOrFail($productId);

//         // Tính toán giá sản phẩm sau khi áp dụng giảm giácod
//         $tt = $product->price - (($product->price * $product->discount) / 100);


//         //khoi tao 1 array chua tt cart tren session
//         $cart = session()->get('cart', []);

//         //kiem tra xem san pham da co trong cart chua
//         if (isset($cart[$productId])) {
//             $cart[$productId]['quantity'] += $quantity;
//         } else {
//             //sp chua co trong cart
//             $tt = $product['price'] - (($product['price']  * $product['discount']) / 100);
//             $cart[$productId] = [
//                 'name' => $product->name,
//                 'price' => $tt,
//                 'quantity' => $quantity,
//                 'img' => $product->img,
//             ];
//         }

//         //update lai session
//         session()->put('cart', $cart);
//         // dd(session()->get('cart'));

//         return redirect()->back();
//         // return view('client.home.addCart', compact('categories'));
//     }
//     public function updateCart(Request $request)
//     {
//         $cartNew = $request->input('cart', []);
//         session()->put('cart', $cartNew);
//         return redirect()->back();
//     }
// }
