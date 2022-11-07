<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Services\Blog\BlogService;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index()
    {
        return view('admin.blog.list', [
            'title' => 'Danh sách blog',
            'blogs' => $this->blogService->get()
        ]);
    }

    public function create()
    {
        return view('admin.blog.add', [
            'title' => 'Thêm blog'
        ]);
    }

    public function store(BlogRequest $request)
    {
        $result = $this->blogService->insert($request);
        return redirect()->back();
    }

    public function show(Blog $blog)
    {
        #dd($blog);
        return view('admin.blog.edit', [
            'title' => 'Chỉnh sửa blog',
            'blog' => $blog
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $result = $this->blogService->update($request, $blog);
        if ($result) {
            return redirect('admin/blogs/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request){
        $result=$this->blogService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công',
            ]);
        }

        return response()->json([
            'error' => true,
        ]);
    }
}
