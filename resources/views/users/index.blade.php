@extends('users.layout')

@section('users')
    <div class="row row-cols-5 gx-0">
        <div class="col">
            @include('users.sidebar.sidebar')
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

                Showing 1–9 of 48 results
            </div>
            {{-- data product --}}
            <div id="grid" class="relative w-100 row row-cols-4 g-5 left-[7.5px] p-5">
                @include('users.data')
            </div>
            <div class="flex justify-center mb-5">
                @include('vendor.pagination')
            </div>
            <footer class="credit text-center">Author: shipra - Distributed By:
                <a title="Awesome web design code &amp; scripts" href="https://www.codehim.com?source=demo-page"
                    target="_blank">CodeHim</a>
            </footer>
        </div>

    </div>
    @include('users.handleCart')
    <script>
        const showSelectColorBox = (productCard) => {
            const selectColorBox = productCard.find('.color-box')

            selectColorBox.show()
            selectColorBox.find('.btn-add-small').click(function() {
                let colorId = $(this).parent().find('.input-color:checked').val()
                let colorName = $(this).parent().find('.input-color:checked').data('color')
                const color = {
                    id: colorId,
                    name: colorName
                }

                if (colorId) {
                    addCartInterface(productCard, 2, color);
                    selectColorBox.hide()
                }
            })
            selectColorBox.find('.btn-cancel-small').click(function() {
                selectColorBox.hide()
            })
        }

        $(".add_to_cart").click(function() {
            const productCard = $(this).parent().parent().parent();
            showSelectColorBox(productCard)
        });

        $(".add-cart-large").each(function(i, e) {
            $(e).click(function() {
                const productCard = $(this).parent().parent();
                showSelectColorBox(productCard)
            });
        });
    </script>
    {{-- <script>
        $(window).on('hashchange', function() {
            var page = getParameterByName('page');
            if (page && !isNaN(page) && page > 0) {
                getData(page);
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var page = getParameterByName('page', $(this).attr('href'));
                getData(page);
            });
        });

        function getData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                })
                .done(function(res) {
                    $("#grid").empty().html(res);
                    updateUrl(page);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Không có phản hồi từ máy chủ');
                });
        }

        function updateUrl(page) {
            var url = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({
                path: url
            }, "", url + '?page=' + page);
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script> --}}
@endsection
