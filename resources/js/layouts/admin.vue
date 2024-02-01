<template>
    <div>
        <SidebarAdmin />
        <div class="main ml-[250px] bg-[#ecf0f5] text-[1.6rem]">
            <HeaderAdmin />
            <main class="min-h-[calc(100vh-122px)] px-4 pb-[50px] mt-[56px]">
                <router-view></router-view>
            </main>
            <div class="main-footer border-top">
                <div class="container-fluid h-[56px] bg-white flex items-center">
                    <div class="row w-100">
                        <div class="col-md-4 col-xs-12 text-md-left text-center">
                            Powered by <a class="text-[#4e9dcb]"
                                href="https://www.nopcommerce.com/?utm_source=demo-admin-panel&amp;utm_medium=footer&amp;utm_campaign=admin-panel"
                                target="_blank">nopCommerce</a>
                        </div>
                        <div class="col-md-4 col-xs-12 text-center">
                            Sunday, December 17, 2023 8:07 PM
                        </div>
                        <div class="col-md-4 col-xs-12 text-md-right text-center">
                            <b>nopCommerce version 4.60.0</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import HeaderAdmin from "../components/HeaderAdmin.vue"
import SidebarAdmin from "../components/SidebarAdmin.vue"

components: {
    HeaderAdmin,
        SidebarAdmin
}
</script>