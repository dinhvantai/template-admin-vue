import Vue from 'vue'

export default {
    items: [
        {
            name: 'Quản lý',
            url: '/dashboard',
            icon: 'icon-speedometer',
            // badge: {
            //     variant: 'primary',
            //     text: 'NEW'
            // }
        },
        {
            name: 'Menus',
            url: '/menus',
            icon: 'icon-list'
        },
        {
            name: 'Danh mục',
            url: '/categories',
            icon: 'icon-list'
        },
        {
            name: 'Sản phẩm',
            icon: 'icon-list',
            children: [
                {
                    name: 'Danh sách',
                    url: '/products',
                },
                {
                    name: 'Thêm mới',
                    url: '/products/add',
                }
            ]
        },
        {
            name: 'Bài viết',
            icon: 'icon-list',
            children: [
                {
                    name: 'Danh sách',
                    url: '/posts',
                },
                {
                    name: 'Thêm mới',
                    url: '/posts/add',
                }
            ]
        },
        // {
        //     title: true,
        //     name: 'UI elements',
        //     class: '',
        //     wrapper: {
        //         element: '',
        //         attributes: {}
        //     }
        // },
    ]
}
