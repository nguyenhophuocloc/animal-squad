<?php

namespace App\Http\Services\Slider;

use App\Models\Slider;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request)
    {
        try {
            Slider::create($request->all());
            Session::flash('success', 'Thêm slider thành công');
        } catch (Exception $err) {
            Session::flash('error', 'Thêm slider thất bại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }

    public function update($request, $slider)
    {
        try {
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Chỉnh sửa thành công');
        } catch (Exception $err) {
            Session::flash('error', 'Chỉnh sửa thất bại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $slider = Slider::where('id', $request->input('id'))->first();
        if ($slider) {
            $path = str_replace('storage', 'public', $slider->thumb);
            //đổi đường dẫn từ storage thành public mới xóa ảnh trong máy được
            Storage::delete($path);
            $slider->delete();
            return true;
        }
        return false;
    }

    //homepage
    public function show()
    {
        return Slider::where('active', 1)->orderBy('sort_by')->get();
    }
}
