@extends('user.layout')

@section('userTitle', 'Trang chủ')
@section('seoDescription', 'Trang chủ')
@section('seoKeyword', 'Trang chủ')

@section('content')
    <div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="home_adv">
            
            @include('user.library.slider')

            <div style="color: rgb(255, 255, 255);background: purple; width: 255px; height: 57px;text-align:center;float:right;padding:10px 0px;">
                <h2>
                    <div>
                        <div style="width: 40%; line-height: 60px; float:left; font-size: 16px;">
                            HOTLINE
                        </div>
                        <div style="width: 60%; line-height: 30px; float:left">
                            <p>
                                <span style="font-size:14px;">0943.044.115</span>
                            </p>
                            <p>
                                <span style="font-size:14px;">0975.801.420</span>
                            </p>
                        </div>
                    </div>
                    {{--  <span style="color: rgb(255, 255, 0);">
                        <span style="font-size: 12px;">
                            <span style="font-size: 16px;">HOTLINE:
                                <span style="font-size:14px;">0917.819.833</span>
                            </span>
                        </span>
                        <br>
                        <span style="font-size: 12px;">
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            <span style="font-size:14px;">
                                0977.018.686
                            </span>
                        </span>
                    </span>  --}}
                </h2>
            </div>
            {{--  <a href="http://minhan.com.vn/news/Khuyen-mai/Khuyen-mai-50-doi-voi-goi-Camera-co-ban-180/"
                target="_blank">
                <img alt="" src="./camera_files/quang-cao.png" style="width: 255px; height: 150px;">
            </a>  --}}
            <div style="clear: both;height: 0px;"> &nbsp;</div>
        </div>
        <div style="clear:both"></div>

        <div class="span-19">
            <div id="products">
                @foreach($homeCategories as $category)
                    <div class="grid clearfix">
                        <div class="block_title">
                            <div class="bg_left_title"></div>
                            <div style="float: left;">
                                <p>
                                    <a href="{{ route('user.category.parent', [$category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </p>
                            </div>
                            <div class="sub_tab_procate">
                                @foreach($category->childrenCategories as $children)
                                    <a href="/">|</a>                                
                                    <a href="{{ route('user.category.children', [$category->slug, $children->slug]) }}">
                                        {{ $children->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix">
                            @foreach ($category->products as $product)
                                <div class="items" style="width:33.333333333333%">
                                    <div class="items_content">
                                        <div class="content_top">
                                            <a href="{{ route('user.product.detail', [$product->slug]) }}" title="{{ $product->name }}">
                                                <img src="{{ Croppa::url('/' . $product->image, 80, null, array('resize')) }}" 
                                                    alt="{{ $product->name }}" 
                                                    style="max-height:80px;max-width:80px;"
                                                />
                                            </a>
                                            <br>
                                        </div>
                                        <div class="item_brief">
                                            <span>
                                                <a href="{{ route('user.product.detail', [$product->slug]) }}" title="{{ $product->name }}">
                                                    {{ $product->name }}
                                                </a>    
                                            </span>
                                            <p class="content_price">
                                                <span class="money">{{ $product->price }}</span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div style="clear:both"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="span-5 last">

            @include('user.library.news-hot')
           
            @include('user.library.statistics')

        </div>

        <div class="clear"></div>

        <div style="color: rgb(84, 84, 84);font-size: 18px;word-spacing: -1px;text-indent: 20px;font-weight: normal; ">
            <span style="color:rgb(0, 0, 205);">Khách hàng- Đối tác chính</span>
        </div>
        <div style="height:40px; width: 970px; margin: 0 auto; overflow: hidden;">
            <div style="height:40px; width: 970px; margin: 0 auto;animation: notify_textmove 25s linear infinite;-webkit-animation: notify_textmove 25s linear infinite;">
                <a href="http://minhan.com.vn/shops/Wansview/">
                    {{--  <img alt="" height="29" src="./camera_files/genviet.jpg" width="81">  --}}
                </a>
            </div>
        </div>
    </div>
@endsection
