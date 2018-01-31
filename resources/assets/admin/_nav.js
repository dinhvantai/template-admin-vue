import Vue from 'vue'

export default {
    items: [
        {
            name: 'Dashboard',
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
            name: 'Categories',
            url: '/categories',
            icon: 'icon-list'
        },
        {
            name: 'Products',
            icon: 'icon-list',
            children: [
                {
                    name: 'List',
                    url: '/products',
                },
                {
                    name: 'Add',
                    url: '/products/add',
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
