const admin = [
    {
        path: "/admin",
        component: () => import("../layouts/admin.vue"),
        children: [
            {
                path: "products",
                name: "admin-products",
                component: () => import("../pages/admin/products/index.vue")
            },
            {
                path: "categories",
                name: "admin-categories",
                component: () => import("../pages/admin/categories/index.vue")
            },
            {
                path: "colors",
                name: "admin-colors",
                component: () => import("../pages/admin/colors/index.vue")
            },
            {
                path: "sizes",
                name: "admin-sizes",
                component: () => import("../pages/admin/sizes/index.vue")
            },
            {
                path: "images",
                name: "admin-images",
                component: () => import("../pages/admin/images/index.vue")
            },
            {
                path: "images",
                name: "admin-images",
                component: () => import("../pages/admin/images/index.vue")
            },
        ]
    },
];

export default admin