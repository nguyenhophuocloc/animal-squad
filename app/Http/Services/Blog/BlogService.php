<?php

namespace App\Http\Services\Blog;

use App\Models\Blog;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

class BlogService
{

    public function insert($request)
    {
        #dd($request->input());
        try {
            $request->except('_token');
            Blog::create($request->all());
            Session::flash('success', 'Tạo blog thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Tạo blog thất bại');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function get()
    {
        return Blog::where('active', 1)->orderByDesc('id')->paginate(15);
    }

    public function update($request, $blog)
    {
        try {
            $blog->fill($request->input());
            $blog->save();
            Session::flash('success', 'Cập nhật blog thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật blog lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $blog = Blog::find($request->id);
        if ($blog) {
            $blog->delete();
            return true;
        }

        return false;
    }

    //Customer
    public function show()
    {
        return Blog::where('active', 1)->orderByDesc('id')->paginate(4);
    }

    public function getDetail($id)
    {
        return Blog::where('id', $id)->first();
    }
}
