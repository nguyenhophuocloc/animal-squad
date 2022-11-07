@extends('admin.main')



@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ngày đặt hàng</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $key=>$customer)
        <tr>
            <th>{{$customer->id}}</th>
            <th>{{$customer->name}}</th>
            <th>{{$customer->phone}}</th>
            <th>{{$customer->email}}</th>
            <th>{{$customer->created_at}}</th>

            <th>
                <a class="btn btn-secondary btn-sm" href="/admin/customers/view/{{$customer->id}}">
                    <i class="fa fa-info-circle"></i>
                </a>
                {{-- <a class="btn btn-danger btn-sm" href="#"
                    onclick="removeRow({{$customer->id}}, '/admin/customers/destroy')">
                    <i class="fas fa-trash"></i>
                </a> --}}
            </th>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="card-footer clearfix">
    {!! $customers->links() !!}
</div>
@endsection