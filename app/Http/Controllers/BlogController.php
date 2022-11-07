<?php

namespace App\Http\Controllers;

use App\Http\Services\Blog\BlogService;
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
        #dd($this->blogService->show());
        return view('blog.list', [
            'title' => 'Blog',
            'blogs' => $this->blogService->show()
        ]);
    }

    public function show(Request $request, $id, $slug = '')
    {
        $blog = $this->blogService->getDetail($id);
        #dd($blog);
        return view('blog.detail', [
            'title' => $blog->name,
            'blog' => $blog
        ]);
    }
}
