<template>
    <div>
        <div class="row row-cols-5 gx-0">
        <div class="col">
            <SidebarHome/>
        </div>
        <div class="flex-1 relative">
            <div id="grid-selector">
                <div id="grid-menu">
                    View:
                    <ul>
                        <li class="largeGrid"><a href=""></a></li>
                        <li class="smallGrid"><a class="active" href=""></a></li>
                    </ul>
                </div>
            </div>
            <div class="min-h-[calc(100vh-122px)]">
                <div id="grid" class="relative w-100 row row-cols-4 g-5 left-[7.5px] p-5">
                    List SP
                </div>
                <div class="flex justify-center mb-5">
                    Pagination
                </div>
            </div>
            <footer class="credit text-center">Author: shipra - Distributed By:
                <a title="Awesome web design code &amp; scripts" href="https://www.codehim.com?source=demo-page"
                    target="_blank">CodeHim</a>
            </footer>
        </div>
    </div>
    </div>
</template>

<script setup>
    import SidebarHome from '../../components/SidebarHome.vue'

    components:{
        SidebarHome
    }
</script>