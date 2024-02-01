<template>
    <div id="header" class="border-bottom d-flex justify-content-between align-items-center h-[96px] pl-[45px]">
        <ul class="d-flex">
            <li><a class="text-uppercase fw-bold mr-[30px] tracking-[1px]" href="#">Home</a></li>
            <li><a class="text-uppercase fw-bold mr-[30px] tracking-[1px]" href="#">BRANDS</a></li>
            <li><a class="text-uppercase fw-bold mr-[30px] tracking-[1px]" href="#">DESIGNERS</a></li>
            <li><a class="text-uppercase fw-bold mr-[30px] tracking-[1px]" href="#">CONTACT</a></li>
        </ul>
        <ul class="d-flex h-100">
            <li class="w-[100px] border-start d-flex justify-content-center align-items-center">
                <span class="material-symbols-outlined text-[4rem]">
                    favorite
                </span>
            </li>
            <li class="min-w-[100px] border-start d-flex justify-content-center align-items-center">
                <div class="cursor-pointer header-icon-user relative">
                    <span class="material-symbols-outlined text-[3.5rem]">
                        person
                    </span>

                    <ul class="header-user-box absolute w-max rounded-lg shadow-md bg-white right-[1rem] top-[70%] z-10">
                        <li class="py-2 px-3 cursor-default rounded-t-lg border-1 text-center">
                            <strong>Quang</strong>
                        </li>
                        <li class="py-2 px-3 hover:bg-[#eee]">Personal information</li>
                        <li class="py-2 px-3 hover:bg-[#eee] rounded-b-lg">
                            <a class='bg-transparent flex items-center' href='#'>
                                <span class="material-symbols-outlined mr-3">
                                    database
                                </span>
                                Database
                            </a>
                        </li>
                        <li class="py-2 px-3 hover:bg-[#eee] rounded-b-lg">
                            <a class='bg-transparent flex items-center'
                                href="#">
                                <span class="material-symbols-outlined mr-3">
                                    logout
                                </span>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- <a href="#" class="hover:text-[#3c8dbc] text-uppercase fw-bold">
                    <span class="material-symbols-outlined text-[3.5rem]">
                        login
                    </span>
                </a> -->
            </li>
        </ul>
    </div>
</template>


<script setup>
import { onMounted } from 'vue';

onMounted(() => {
    $(document).ready(function () {
        $('.header-user-box').hide()
        let hideTimer = 0;
        $('.header-icon-user').hover(
            function () {
                // Mouse enters
                clearTimeout(hideTimer); // Hủy bỏ timer nếu có
                $('.header-user-box').show();
            },
            function () {
                // Mouse leaves
                hideTimer = setTimeout(function () {
                    $('.header-user-box').hide();
                }, 1000); // 1 giây trễ trước khi ẩn
            }
        );
    })
})
</script>