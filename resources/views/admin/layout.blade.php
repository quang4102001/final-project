@extends('index')

@section('body')
    <div>
        @include('admin.sidebar.index')

        <div class="main ml-[250px] bg-[#ecf0f5] text-[1.6rem]">
            @include('admin.header.header')
            <main class="min-h-[calc(100vh-122px)] px-4 pb-[50px] mt-[56px]">
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
    <script>
        $(document).ready(function() {
            $('#quantitySelect').change(function() {
                const pagination = $(this).find('option:selected').val()
                // Lấy URL hiện tại
                var currentUrl = window.location.href;

                // Kiểm tra xem có tham số truy vấn trong URL không
                var queryIndex = currentUrl.indexOf('?');
                var queryString = queryIndex !== -1 ? currentUrl.substring(queryIndex + 1) : '';

                // Chuyển tham số truy vấn thành một đối tượng
                var params = {};
                queryString.split('&').forEach(function(pair) {
                    pair = pair.split('=');
                    params[pair[0]] = pair[1];
                });

                // Thêm hoặc cập nhật giá trị 'pagination' trong đối tượng tham số truy vấn
                params['pagination'] = pagination;

                // Xây dựng URL mới với tham số truy vấn cập nhật
                var newUrl = currentUrl.split('?')[0] + '?' + Object.keys(params).map(function(key) {
                    return key + '=' + params[key];
                }).join('&');

                // Chuyển hướng đến URL mới
                window.location.href = newUrl;
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            const checkAllChange = function() {
                var isChecked = $("#checkAll").prop("checked");

                $(".checkBox").prop("checked", isChecked);
            };

            // Khi click vào checkbox ở header
            $("#checkAll").change(function() {
                checkAllChange();
            });

            // Khi click vào th hoặc td, thay đổi trạng thái của checkbox
            $("td").click(function(e) {
                if (e.target.type !== "checkbox") {
                    var checkbox = $(this).find(".checkBox");

                    checkbox.prop("checked", !checkbox.prop("checked"));
                    const allChecked =
                        $(".checkBox").length === $(".checkBox:checked").length;
                    $("#checkAll").prop("checked", allChecked);
                }
            });

            $("th").click(function(e) {
                if (e.target.type !== "checkbox") {
                    var checkbox = $(this).find("#checkAll");

                    checkbox.prop("checked", !checkbox.prop("checked"));
                    checkAllChange();
                }
            });

            $(".checkBox").each(function(i) {
                $(this).change(function() {
                    const allChecked =
                        $(".checkBox").length === $(".checkBox:checked").length;
                    $("#checkAll").prop("checked", allChecked);
                });
            });
        });
    </script>
@endsection
