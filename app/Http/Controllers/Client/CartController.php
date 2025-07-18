<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart');
        return view('client.pages.cart', ['cart' => $cart]);
    }

    public function checkout(){
        $user = Auth::user();
        $cart = session()->get('cart');

        return view('client.pages.checkout',['user' => $user,'cart' => $cart]);
    }


    public function addProductToCart(Product $product){
        $cart = session()->get('cart', []);
    
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'qty' => ($cart[$product->id]['qty'] ?? 0) + 1,
            'main_image' => asset('images/'. $product->main_image)
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Add product to cart successfully']);
    }

    public function placeOrder(Request $request){
        //Validation
        
        try{
            DB::beginTransaction();

            $total = 0;
            $cart = session()->get('cart', []);
            foreach($cart as $item){
                $total += $item['price'] * $item['qty'];
            }
            
            //Eloquent - insert record to order table
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->status = 'pending';
            $order->subtotal = $total;
            $order->total = $total;
            $order->save(); //insert record
    
            foreach($cart as $productId => $item){
                // - insert record to order item table
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->price = $item['price'];
                $orderItem->name = $item['name'];
                $orderItem->qty = $item['qty'];
                $orderItem->save(); //insert record
            }
    
            //Eloquent - Mass Assignment - insert record to order payment method table
            $orderPaymentMethod = OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'status' => 'pending'
            ]);
    
            //Update phone of User
            $user = User::find(Auth::user()->id);
            $user->phone = $request->phone;
            $user->save(); //update

            DB::commit();

            if($request->payment_method === 'cod'){
                //Empty cart
                session()->put('cart', []);

                //Send mail to customer + order
                Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailCustomer($order));

                //Send mail to admin + order
                Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailAdmin($order));

                //Minus qty of product
                foreach ($order->orderItems as $orderItem) {
                    $product = Product::find($orderItem->product_id);
                    $product->qty -= $orderItem->qty;
                    $product->save();
                }
            }else if($request->payment_method === 'vnpay'){

                // VNPAY_TMNCODE=
                // VNPAY_HASHSECRET=
                // VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
                // VNPAY_RETURNURL=http://localhost:8000/vnpay_return
                // VNPAY_APIURL=http://sandbox.vnpayment.vn/merchant_webapi/merchant.html
                // VNPAY_APIURL_APIURL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction

                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $startTime = date("YmdHis");
                $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

                $vnp_TxnRef = $order->id;
                $vnp_Amount = $order->total;
                $vnp_Locale = 'vn'; 
                $vnp_BankCode = 'VNBANK'; 
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; 
                $vnp_HashSecret = env('VNPAY_HASHSECRET');

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNPAY_TMNCODE'),
                    "vnp_Amount" => $vnp_Amount * 100 * 23500,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => env('VNPAY_RETURNURL'),
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire,
                    "vnp_BankCode" => $vnp_BankCode,
                );

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNPAY_URL') . "?" . $query;

                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                return redirect()->to($vnp_Url);
            }            

        }catch(Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return redirect()->route('client.home.index');
    }
}
