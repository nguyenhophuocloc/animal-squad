<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Models\Customer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        return view('admin.cart.customer', [
            'title' => 'Danh sách đơn đặt hàng',
            'customers' => $this->cartService->getCustomer(),
        ]);
    }

    public function show(Customer $customer)
    {
        $carts = $this->cartService->getProductForCarts($customer);
        return view('admin.cart.detail', [
            'title' => 'Chi tiết đơn hàng ' . $customer->name,
            'customer' => $customer,
            'carts' => $carts,
        ]);
    }
}
