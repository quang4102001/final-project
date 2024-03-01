@extends('admin.layout')

@section('admin')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg z-0">
        <div class="container-fluid py-4">
            <div class="p-5 mt-4 rounded-lg shadow-lg bg-white">
                <p class="text-4xl mb-5">Dashboard</p>
                <div class="grid grid-cols-4 gap-4">
                    <div class="my-4 rounded-lg shadow-md">
                        <div class="bg-[#f7f7f7] rounded-t-lg p-4 pt-3 relative">
                            <div
                                class="position-absolute flex justify-center items-center bg-gradient-to-r from-[#42424a] to-[#191919] p-4 rounded-lg top-0 transform translate-y-[-50%]">
                                <i class="fa-solid fa-coins text-white text-3xl px-2"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-2xl mb-0 text-capitalize">Today's Money</p>
                                <h4 class="mb-0 text-3xl mt-3 fw-bold">$53k</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="rounded-b-lg bg-[#f7f7f7] p-4">
                            <p class="">
                                <span class="text-success fw-bold">+55%</span>
                                than lask week
                            </p>
                        </div>
                    </div>
                    <div class="my-4 rounded-lg shadow-md">
                        <div class="bg-[#f7f7f7] rounded-t-lg p-4 pt-3 relative">
                            <div
                                class="position-absolute flex justify-center items-center bg-gradient-to-r from-[#D81B60] to-[#EC407A] p-4 rounded-lg top-0 transform translate-y-[-50%]">
                                <i class="fa-solid fa-user text-white text-3xl px-2"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-2xl mb-0 text-capitalize">Today's Users</p>
                                <h4 class="mb-0 text-3xl mt-3 fw-bold">2,300</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="rounded-b-lg bg-[#f7f7f7] p-4">
                            <p class="">
                                <span class="text-success fw-bold">+3%</span>
                                than lask month
                            </p>
                        </div>
                    </div>
                    <div class="my-4 rounded-lg shadow-md">
                        <div class="bg-[#f7f7f7] rounded-t-lg p-4 pt-3 relative">
                            <div
                                class="position-absolute flex justify-center items-center bg-gradient-to-r from-[#43A047] to-[#66BB6A] p-4 rounded-lg top-0 transform translate-y-[-50%]">
                                <i class="fa-solid fa-user text-white text-3xl px-2"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-2xl mb-0 text-capitalize">New Clients</p>
                                <h4 class="mb-0 text-3xl mt-3 fw-bold">3,462</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="rounded-b-lg bg-[#f7f7f7] p-4">
                            <p class="">
                                <span class="text-danger fw-bold">-2%</span>
                                than yesterday
                            </p>
                        </div>
                    </div>
                    <div class="my-4 rounded-lg shadow-md">
                        <div class="bg-[#f7f7f7] rounded-t-lg p-4 pt-3 relative">
                            <div
                                class="position-absolute flex justify-center items-center bg-gradient-to-r from-[#1A73E8] to-[#49a3f1] p-4 rounded-lg top-0 transform translate-y-[-50%]">
                                <i class="fa-solid fa-coins text-white text-3xl px-2"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-2xl mb-0 text-capitalize">Sales</p>
                                <h4 class="mb-0 text-3xl mt-3 fw-bold">$103,430</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="rounded-b-lg bg-[#f7f7f7] p-4">
                            <p class="">
                                <span class="text-success fw-bold">+5%</span>
                                than yesterday
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
