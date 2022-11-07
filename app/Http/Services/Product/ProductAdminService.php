<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductAdminService
{
    public function getMenu()
    {
        $menus = Menu::where('active', '=', 1)->get();
        return $menus;
    }

    public function isValidPrice($request)
    {
        if (($request->input('price') != 0 && $request->input("price_sale") != 0) && $request->input('price_sale') >= $request->input('price')) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int) $request->input("price") == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return true;
    }

    public function insert($request)
    {
        $isValidPrices = $this->isValidPrice($request);
        if ($isValidPrices == false)   return false;
        try {
            $request->except('_token');
            Product::create($request->all());
            Session::flash('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm sản phẩm lỗi');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function get()
    {
        return Product::with('menu')->orderByDesc('id')->paginate(15);
    }

    public function update($request, $product)
    {
        $isValidPrices = $this->isValidPrice($request);
        if ($isValidPrices == false)   return false;
        try {
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật sản phẩm lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        //cái id này lấy từ ajax
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
