@extends('main')
@section('content')
<section class="bg0 p-t-52 p-b-20 m-t-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">
                    <!--  -->
                    <div class="wrap-pic-w how-pos5-parent">
                        <img src="{{$blog->thumb}}" alt="IMG-BLOG">

                        <div class="flex-col-c-m size-123 bg9 how-pos5">
                            <span class="ltext-107 cl2 txt-center">
                                {{substr($blog->created_at,8,2)}}
                            </span>

                            <span class="stext-109 cl3 txt-center">
                                {{\App\Helpers\Helper::monthYearFormat($blog->created_at)}}
                            </span>
                        </div>
                    </div>

                    <div class="p-t-32">
                        <span class="flex-w flex-m stext-111 cl2 p-b-19">
                            <span>
                                <span class="cl4">By</span> Admin
                                <span class="cl12 m-l-4 m-r-6">|</span>
                            </span>

                            <span>
                                22 Jan, 2018
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

                        <h4 class="ltext-109 cl2 p-b-28">
                            {{$blog->name}}
                        </h4>


                        {!!$blog->content!!}



                    </div>



                    <!--Comment  -->
                    {{-- <div class="p-t-40">
                        <h5 class="mtext-113 cl2 p-b-12">
                            Leave a Comment
                        </h5>

                        <p class="stext-107 cl6 p-b-40">
                            Your email address will not be published. Required fields are marked *
                        </p>

                        <form>
                            <div class="bor19 m-b-20">
                                <textarea class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" name="cmt"
                                    placeholder="Comment..."></textarea>
                            </div>

                            <div class="bor19 size-218 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="name"
                                    placeholder="Name *">
                            </div>

                            <div class="bor19 size-218 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="email"
                                    placeholder="Email *">
                            </div>

                            <div class="bor19 size-218 m-b-30">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="web"
                                    placeholder="Website">
                            </div>

                            <button class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04">
                                Post Comment
                            </button>
                        </form>
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
</section>
@endsection