@extends('index')

@section('body')
    <div>
        @include('admin.sidebar.index')

        <div class="main ml-[250px] bg-[#ecf0f5] text-[1.6rem]">
            @include('admin.header.header')
            <main class="px-4 pb-[50px] mt-[56px]">
                @yield('admin')
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
@endsection
