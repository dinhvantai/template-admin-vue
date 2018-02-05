<div id="header">
    <div id="logo">
        <a title="" href="/">
            <img src="http://via.placeholder.com/120x40" alt="Camera">
        </a>
    </div>
    <div class="searchfield">
        <form action="/search" method="get" id="skypeSearchForm">
            <div class="typesearch">
                <input class="typeKey" title="Tìm kiếm" type="text" name="q" id="topmenu_search_query" maxlength="60" placeholder="Nhập tên sản phẩm hoặc từ khóa tìm kiếm...">
            </div>
            <input type="submit" value="" class="btnSearch">
        </form>
    </div>
    <div class="content_right">
        content right
    </div>
    <div id="header_nav">
        <ul class="fl" style="float:right; margin-right: 10px" id="navid">
            @foreach($userMenu['left'] as $menu)
                <li>
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        <span>{{ $menu->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <ul class="fl" id="navid">
            @foreach($userMenu['right'] as $menu)
                <li>
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        <span>{{ $menu->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div style="clear:both"></div>
</div>