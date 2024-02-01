const home = [
    {
        path: "/",
        component: () => import("../layouts/home.vue"),
        children: [
            {
                path: "",
                name: "home-index",
                component: () => import("../pages/home/index.vue")
            },
        ]
    },
];

export default home