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
            </div>
            {{-- data product --}}
            <div class="min-h-[calc(100vh-122px)]">
                <div id="grid" class="relative w-100 row row-cols-4 g-5 left-[7.5px] p-5">
                    @include('home.data')
                </div>
                <div class="flex justify-center mb-5">
                    @include('admin.products.vendor.pagination')
                </div>
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

        const makeCartItem = (name, img, price, id) => {
            return `<div class="cart-item mt-4 relative">
                <div class="d-flex">
                    <div class="bg-[url('${img}')] w-[50px] h-[50px] bg-cover">
                    </div>
                    <div class="flex-1 ml-5 pr-[45px]">
                        <p class="cart-item-title">${name}</p>
                        <p class="cart-item-title text-[#5ff7d2] fw-bold">$${price}</p>
                    </div>
                </div>
                <div class="cart-item-border mr-[45px] border-bottom mt-3"></div>
                <i data-id="${id}" class="fa-solid fa-xmark cart-item-close hidden cursor-pointer absolute right-[18px] top-[8px] text-[2rem] text-[#ccc] p-3"></i>
            </div>`;
        };

        const addCartInterface = (productCard, type, color) => {
            const position = productCard.offset();
            //lấy data
            const productImage = $(productCard).find("img").get(0).src;
            const productId = $(productCard).find(".product_id").get(0).innerHTML;
            const productName = $(productCard)
                .find(".product_name")
                .get(0).innerHTML;
            const productPrice = parseInt($(productCard).find(".product_price").get(0).innerHTML.substring(1));

            // tạo chuyển động
            $("body").append('<div class="floating-cart"></div>');
            const cart = $(".floating-cart");
            if (type == "1") {
                $(
                    "<img src='" +
                    productImage +
                    "' class='floating-image-large' />"
                ).appendTo(cart);
            } else {
                productCard.clone().appendTo(cart);
            }
            $(cart)
                .css({
                    top: position.top + "px",
                    left: position.left + "px"
                })
                .fadeIn("slow")
                .addClass("moveToCart");
            setTimeout(function() {
                $("body").addClass("MakeFloatingCart");
            }, 800);

            setTimeout(function() {
                $("div.floating-cart").remove();
                $("body").removeClass("MakeFloatingCart");
                const cartItem = makeCartItem(
                    productName,
                    productImage,
                    productPrice,
                    productId,
                );
                $("#cart-list").prepend(cartItem);
                $("#cart-no-item").hide();
                $("#checkout").fadeIn(500);

                $("#cart-list .cart-item")
                    .first()
                    .find(".cart-item-close")
                    .click(function() {
                        exceptFromCart(productId, color.id);
                        $(this).closest(".cart-item").fadeOut(300, function() {
                            $(this).remove();
                            if ($("#cart-list .cart-item").size() == 0) {
                                $("#cart-no-item").fadeIn(500);
                                $("#checkout").fadeOut(500);
                            }
                        });
                    });
            }, 800);
            addToCart(productId, color.id);
        };
    </script>
@endsection
