<?php

namespace App\Http\Controllers;

use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;

    public function __construct(SliderService $slider, MenuService $menuService, ProductService $productService)
    {
        $this->slider = $slider;
        $this->menu = $menuService;
        $this->product = $productService;
    }

    public function index()
    {
      
        return view('home', [
            'title' => 'Animal Squad',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get(),
        ]);
    }

    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);

        if (count($result)!=0) {
            $html = view('products.list', ['products' => $result])->render();

            return response()->json([
                'html' => $html
            ]);
        }

        return response()->json([
            'html' => ''
        ]);
    }
}
