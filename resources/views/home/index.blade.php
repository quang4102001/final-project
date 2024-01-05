@extends('home.layout')

@section('users')
    <div class="row row-cols-5 gx-0">
        <div class="col">
            @include('home.sidebar.sidebar')
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
                @include('home.data')
            </div>
            <div class="flex justify-center mb-5">
                @include('admin.products.vendor.pagination')
            </div>
            <footer class="credit text-center">Author: shipra - Distributed By:
                <a title="Awesome web design code &amp; scripts" href="https://www.codehim.com?source=demo-page"
                    target="_blank">CodeHim</a>
            </footer>
        </div>

    </div>
    @include('home.handleCart')
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
            const productCard = $(this).closest(".product");
            showSelectColorBox(productCard)
        });

        $(".add-cart-large").each(function(i, e) {
            $(e).click(function() {
                const productCard = $(this).closest(".product");
                showSelectColorBox(productCard)
            });
        });
    </script>
@endsection
