<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);

        if ($result == false) {
            return redirect()->back();
        }
        return redirect('/carts');
    }

    public function show(Request $request)
    {

        if ($request->input('vnp_Amount')) {
            Session::flash('success', 'Đặt mua thành công');
            Session::forget('carts');
            $products = $this->cartService->getProduct();
            return view('carts.list', [
                'title' => "Giỏ hàng",
                'products' => $products,
                'carts' => Session::get('carts'),
            ]);
        } else {
            $products = $this->cartService->getProduct();
            return view('carts.list', [
                'title' => "Giỏ hàng",
                'products' => $products,
                'carts' => Session::get('carts'),
            ]);
        }
    }

    public function update(Request $request)
    {
        $result = $this->cartService->update($request);

        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $result = $this->cartService->remove($id);

        return redirect('/carts');
    }

    public function addCart(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'payment' => 'required'
        ]);

        if ($request->payment == 1) {
            #COD
            $this->cartService->addCart($request);
            return redirect()->back();
        } else if ($request->payment == 2) {
            #VNPAY
            $this->cartService->vnpay($request);
        } else {
            Session::flash('error', 'Vui lòng lựa chọn hình thức thanh toán');
            return redirect()->back();
        }
    }
}
