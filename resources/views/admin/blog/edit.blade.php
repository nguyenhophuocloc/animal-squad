@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">


        <div class="form-group">
            <label for="menu">Tiêu đề</label>
            <input type="text" name="name" value="{{ $blog->name}}" class="form-control">
        </div>




        <div class="form-group">
            <label>Mô Tả </label>
            <textarea name="description" class="form-control">{{ $blog->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Mô Tả Chi Tiết</label>
            <textarea name="content" id="content" class="form-control">{{  $blog->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="menu">Ảnh bìa</label>
            <input type="file" class="form-control" id="upload">
            <div id="image_show">
                <a href="{{$blog->thumb}}" target="_blank">
                    <img src="{{$blog->thumb}}" width="100px">
                </a>
            </div>
            <input type="hidden" name="thumb" id="thumb" value="{{$blog->thumb}}">
        </div>

        <div class="form-group">
            <label>Kích Hoạt</label>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="1" type="radio" id="active" name="active" {{$blog->active
                == 1 ? 'checked':''}}>
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" {{$blog->active
                == 0 ? 'checked':''}}>
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>


    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Chỉnh sửa Blog</button>
    </div>
    @csrf
</form>
@endsection

@section('footer')
<script>
    CKEDITOR.replace('content');
</script>
@endsection