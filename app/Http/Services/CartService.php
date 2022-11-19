<?php


namespace App\Http\Services;

use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Nette\Utils\Random;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);

        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', [$carts[$product_id]]);

            return true;
        }

        $carts[$product_id] = $qty;

        Session::put('carts', $carts);

        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');

        if (is_null($carts)) return false;

        $productId = array_keys($carts);

        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)->get();
    }

    public function update($request)
    {
        Session::put('carts', $request->input("num-product"));
        return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts');

        unset($carts[$id]);
        Session::put('carts', $carts);

        return true;
    }

    public function addCart($request)
    {
        #dd($request->input());
        try {
            DB::beginTransaction();
            $carts = Session::get('carts');
            if (is_null($carts)) return false;

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content'),
            ]);

            $this->infoProductCart($carts, $customer->id);
            DB::commit();

            Session::flash('success', 'Đặt mua thành công');

            #Queue
            #SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));

            Session::forget('carts');
            return true;
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt mua thất bại');
            return false;
        }
    }

    public function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty' => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price,
            ];
        }

        return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function getProductForCarts($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }

    public function vnpay($request)
    {
        #dd($request->all());

        $app_url = env('VN_PAYURL');

        $generateToken = uniqid();
        $vnpay = array(
            "num_product" => $request->input('num-product'),
            "name" => $request->input('name'),
            "email" =>  $request->input('email'),
            "phone" => $request->input('phone'),
            "address" => $request->input('address'),
            "content" => $request->input('content')
        );
        //Session::put('vnpay', [$vnpay]);



        date_default_timezone_set('Asia/Ho_Chi_Minh');
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $vnp_TmnCode = "ITYONMLH"; //Website ID in VNPAY System
        $vnp_HashSecret = "NKBULTSBOZUPGOHRLAXADCIEQJTXGRZO"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = 'http://'.$app_url.'/carts';
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $generateToken; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderInfo = $request->name;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (int) $request->total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            // "num_product" => $request->input('num-product'),
            // "name" => $request->input('name'),
            // "email" =>  $request->input('email'),
            // "phone" => $request->input('phone'),
            // "address" => $request->input('address'),
            // "content" => $request->input('content'),
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }


        //var_dump($inputData);
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

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url,
        );
        if (isset($_POST['payment'])) {

            $carts = Session::get('carts');
            if (is_null($carts)) return false;

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content') . " - " . $generateToken . " - đã thanh toán",
            ]);

            $this->infoProductCart($carts, $customer->id);

            Session::flash('success', 'Đặt mua thành công');
            Session::forget('carts');

            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }
}
