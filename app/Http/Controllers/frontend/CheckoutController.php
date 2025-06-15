<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth; // Perbaiki huruf kapital di "Support"

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitem = Cart::where('user_id', Auth::id())->get();
        foreach($old_cartitem as $item)
        {
            if(!Product::where('id', $item->prod_id)->where('qty', '>=', $item->prod_qty)->exists())
            {
                $removeItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
                $removeItem->delete();
            }
        }
        $cartitem = Cart::where('user_id', Auth::id())->get();
        return view('frontend.checkout', compact('cartitem'));
    }

    public function placeOrder(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->email = $request->input('email');
        $order->phoneno = $request->input('phoneno');
        $order->address1 = $request->input('address1');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->pincode = $request->input('pincode');
      
        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        foreach ($cartitems_total as $prod) {
            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $order->total_price = $total;
        $order->tracking_no = 'GKY'.rand(1111,9999);
        $order->save();

        $cartitem = Cart::where('user_id', Auth::id())->get();

        foreach($cartitem as $item)
        {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();
        }

        // HAPUS BAGIAN INI YANG MENYEBABKAN ERROR
        // if(Auth::user()->address1 == NULL)
        // {
        //     $user = User::where('id',Auth::id())->first();
        //     $user->fname = $request->input('fname');
        //     $user->phoneno = $request->input('phoneno');
        //     $user->address1 = $request->input('address1');
        //     $user->city = $request->input('city');
        //     $user->state = $request->input('state');
        //     $user->country = $request->input('country');
        //     $user->pincode = $request->input('pincode');   
        //     $user->update();
        // }

        // Perbaiki cara hapus cart
        Cart::where('user_id', Auth::id())->delete();
        
        return redirect('/')->with('status', "Pesanan berhasil dibuat!");

    }
}