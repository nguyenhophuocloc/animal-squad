@extends('main')

@section('content')

<div class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/images/contact.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Blog
    </h2>
</div>
<section class="bg0 p-t-62 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">
                    @foreach ($blogs as $blog)
                    
                    <!-- item blog -->
                    <div class="p-b-63">
                        <a href="/blog/{{$blog->id}}-{{\Str::slug($blog->name,'-')}}.html"
                            class="hov-img0 how-pos5-parent">
                            <img src="{{$blog->thumb}}" alt="IMG-BLOG">

                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    {{substr($blog->created_at,8,2)}}
                                </span>
    
                                <span class="stext-109 cl3 txt-center">
                                    {{\App\Helpers\Helper::monthYearFormat($blog->created_at)}}
                                </span>
                            </div>
                        </a>

                        <div class="p-t-32">
                            <h4 class="p-b-15">
                                <a href="/blog/{{$blog->id}}-{{\Str::slug($blog->name,'-')}}.html"
                                    class="ltext-108 cl2 hov-cl1 trans-04">
                                    {{$blog->name}}
                                </a>
                            </h4>

                            <p class="stext-117 cl6">
                                {{$blog->description}}
                            </p>

                            <div class="flex-w flex-sb-m p-t-18">
                                <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                                    <span>
                                        <span class="cl4">By</span> Admin
                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    {{-- <span>
                                        StreetStyle, Fashion, Couple
                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    <span>
                                        8 Comments
                                    </span> --}}
                                </span>

                                <a href="/blog/{{$blog->id}}-{{\Str::slug($blog->name,'-')}}.html"
                                    class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Continue Reading

                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    {!! $blogs->links()!!}

                    <!-- Pagination -->
                    {{-- <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                        <a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
                            1
                        </a>

                        <a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7">
                            2
                        </a>
                    </div> --}}
                </div>
            </div>


        </div>
    </div>
</section>
@endsection