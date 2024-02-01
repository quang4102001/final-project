<template>
    <header class="bg-[#343a40] h-[56px] flex justify-end items-center px-3 fixed top-0 right-0 left-[250px] z-[999]">
        <div class="cursor-pointer header-icon-user relative text-white">
            <span class="material-symbols-outlined text-[3.5rem] text-inherit">
                person
            </span>

            <ul class="header-user-box absolute w-max rounded-lg shadow-md bg-white right-[1rem] top-[70%] z-10">
                <li class="py-2 px-3 cursor-default rounded-t-lg border-1 text-center">
                    <strong>Admin</strong>
                </li>
                <li class="py-2 px-3 hover:bg-[#eee]">Personal information</li>
                <li class="py-2 px-3 hover:bg-[#eee] rounded-b-lg">
                    <a class='bg-transparent flex items-center' href='#'>
                        <span class="material-symbols-outlined mr-3">
                            logout
                        </span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </header>
</template>

<script setup>
import { onMounted } from 'vue'

onMounted(() => {
    $(document).ready(function () {
        $('.header-user-box').hide()
        let hideTimer = 0
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