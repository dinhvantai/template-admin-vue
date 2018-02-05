@extends('user.layout')

@section('userTitle', $data['product']->name)
@section('seoDescription', $data['product']->seo_description)
@section('seoKeyword', $data['product']->seo_keywork)

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                @php
                    $category = $data['product']->category;
                @endphp
                @if ($data['product']->category->parentCategory)
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.parent', [$category->parentCategory->slug]) }}" 
                        title="{{ $category->parentCategory->name }}"
                    >
                        {{ $category->parentCategory->name }}
                    </a>
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.children', [$category->parentCategory->slug, $category->slug]) }}" 
                        title="{{ $category->name }}"
                    >
                        {{ $category->name }}
                    </a>
                @else
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.parent', [$category->slug]) }}" 
                        title="{{ $category->name }}"
                    >
                        {{ $category->name }}
                    </a>
                @endif
            </h3>

            <div id="detail">
                <div>
                    <span style="float:left; text-align:center">
                        <a href="{{ route('user.product.detail', [$data['product']->slug]) }}" 
                            title="{{ $data['product']->name }}"
                        >
                            <img src="{{ Croppa::url('/' . $data['product']->image, 140, null, array('resize')) }}" 
                                alt="{{ $data['product']->name }}" width="140px" 
                                style="border:1px solid #eeeeee; padding:2px"
                            />
                        </a>
                        <br>
                        <a href="#" title="{{ $data['product']->name }}">
                            <span class="zoom_img">Xem ảnh lớn</span>
                        </a>
                    </span>
                    <div class="info_product fl">
                        <h2>{{ $data['product']->name }}</h2>
                        <span class="date_up">
                            Đăng ngày {{ $data['product']->created_at->format('d-mm-Y H:i:s') }}
                             - 1192 Lượt xem
                        </span>
                        <p>
                            Giá :
                            <span class="money">{{ $data['product']->price }}</span>
                        </p>
                        @if ($data['product']->guarantee)
                            <span class="time_up" style="font-weight:bold">
                                Bảo hành: {{ $data['product']->guarantee }}
                            </span>
                        @endif
                        <br>
                        
                        <div class="clearfix fl">
                            {{ $data['product']->description }}
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="TabView" id="TabView">
                        <div class="Tabs">
                            <a href="javascript:tabview_switch('TabView', 1);" class="Active">Chi tiết sản phẩm</a>
                            <a href="javascript:tabview_switch('TabView', 2);" class="">Hướng dẫn sử dụng</a>
                        </div>
                        <div class="Pages">
                            <div class="Page" style="display: block;">
                               {!! $data['product']->detail !!}
                            </div>
                            <div class="Page" style="display: none;">
                                {!! $data['product']->guide !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block_title">
                    <div class="bg_left_title">
                        <p>Sản phẩm cùng loại</p>
                    </div>
                </div>
                <div id="products" class="clearfix">
                    @foreach($data['productRelation'] as $product)
                        <div class="items" style="width:33.333333333333%">
                            <div class="items_content">
                                <div class="content_top">
                                    <a href="{{ route('user.product.detail', [$product->slug]) }}" 
                                        title="{{ $product->name }}"
                                    >
                                        <img src="{{ Croppa::url('/' . $product->image, 80, null, array('resize')) }}" 
                                            alt="{{ $product->name }}"
                                            style="max-height:80px;max-width:80px;"
                                        />
                                    </a>
                                </div>
                                <div class="item_brief">
                                    <span>
                                        <a href="{{ route('user.product.detail', [$product->slug]) }}"
                                            title="{{ $product->name }}"
                                        >
                                            {{ $product->name }}
                                        </a>
                                    </span>
                                    <p class="content_price">
                                        <span class="money">{{ $product->price }}</span>
                                        <br>
                                    </p>
                                        @if ($product->guarantee)
                                            <span class="time_up">
                                                Bảo hành: {{ $product->guarantee }}
                                            </span>
                                        @endif
                                    <p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>


        <div class="span-5 last">
            <div class="box silver">
                <div class="right_block_title">
                    <div class="bg_left_title">
                        <p>{{ $category->name }}</p>
                    </div>
                </div>
                <div id="smoothmenu2" class="ddsmoothmenu-v">
                    <ul class="ul_sub_menu">
                        @foreach($category->childrenCategories as $children)
                            <li class="">
                                <a class="" 
                                    title="{{ $children->name }}" 
                                    href="{{ route('user.category.children', [$category->slug, $children->slug]) }}"
                                >
                                    {{ $children->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <br style="clear: left">
                </div>
            </div>

            @include('user.library.news-hot')

            @include('user.library.statistics')
            
        </div>
        <div class="clear"></div>
    </div>
@endsection
