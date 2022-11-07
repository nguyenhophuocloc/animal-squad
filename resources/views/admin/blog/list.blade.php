@extends('admin.main')



@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tiêu đề</th>
            <th>Giới thiệu</th>
            <th>Ảnh bìa</th>
            <th>Active</th>
            <th>Update</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($blogs as $key=>$blog)
        <tr>
            <th>{{$blog->id}}</th>
            <th>{{$blog->name}}</th>
            <th>{{$blog->description}}</th>
            <th>
                <a href="{{$blog->thumb}}" target="_blank">
                    <img src="{{$blog->thumb}}" alt="" height="40px">
                </a>
            </th>
            <th>{!! \App\Helpers\Helper::active($blog->active) !!}</th>
            <th>{{$blog->updated_at}}</th>
            <th>
                <a class="btn btn-primary btn-sm" href="/admin/blogs/edit/{{$blog->id}}">
                    <i class="fas fa-edit"></i>
                </a>
                <a class="btn btn-danger btn-sm" href="#"
                    onclick="removeRow({{$blog->id}}, '/admin/blogs/destroy')">
                    <i class="fas fa-trash"></i>
                </a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="card-footer clearfix">
    {!! $blogs->links() !!}
</div>
@endsection