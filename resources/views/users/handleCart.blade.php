{{-- cart and index --}}
<script>
    //make cartItem
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
        const productPrice = parseInt(
            $(productCard).find(".product_price").get(0).innerHTML.substring(1)
        );

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
                    $(this)
                        .parent()
                        .fadeOut(300, function() {
                            exceptFromCart(productId, color.id);
                            $(this).remove();
                            if ($("#cart-list .cart-item").size() == 0) {
                                $("#cart-no-item").fadeIn(500);
                                $("#checkout").fadeOut(500);
                            }
                        });
                });
        }, 800);
        // Thêm vào giỏ hàng
        addToCart(productId, productName, productImage, productPrice, color);
        //
    };

    const makeCartRow = (id, name, img, price, qty, colorId, colorName) => {
        return `<div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div>
                                <img src="${img}"
                                    class="img-fluid rounded-3 w-[65px]" alt="Shopping item">
                            </div>
                            <div class="ms-3">
                                <h5>${name}</h5>
                                <p class="small mb-0">256GB, Navy Blue</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="mr-[40px] h-100 flex items-center">
                                <div class="w-[30px] h-[30px] rounded-full shadow-md bg-[${colorName}]"></div>
                            </div>
                            <div class="mr-[40px]">
                                <input data-id="${id}" type="number" class="cart-input border rounded-lg leading-[2] px-3 w-[80px]" value="${qty}"/>
                            </div>
                            <div>
                                <h5 class="mb-0 w-[80px] quantity">$${qty * price}</h5>
                            </div>
                            <a data-id="${id}" href="#!" class="text-[#dd4b39] cart-item-trash"><i
                                    class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>`;
    };

    const loadCart = () => {
        if (cartUser.length === 0) {
            $("#cart-no-item").show();
            $("#checkout").hide();
        } else {
            $("#cart-no-item").hide();
            $("#checkout").show();
            cartUser.forEach((item, index) => {
                const cartItem = makeCartItem(
                    item.name,
                    item.img,
                    item.price,
                    item.id
                );
                for (let i = 0; i < item.qty; i++) {
                    $("#sidebar #cart-list").append(cartItem);
                    $("#cart-list .cart-item")
                        .last()
                        .find(".cart-item-close")
                        .click(function() {
                            $(this)
                                .parent()
                                .fadeOut(300, function() {
                                    exceptFromCart(item.id, item.colorId);
                                    $(this).remove();
                                    if ($("#cart-list .cart-item").size() == 0) {
                                        $("#cart-no-item").fadeIn(500);
                                        $("#checkout").fadeOut(500);
                                    }
                                });
                        });
                }
                const cartRow = makeCartRow(
                    item.id,
                    item.name,
                    item.img,
                    item.price,
                    item.qty,
                    item.colorId,
                    item.colorName
                );
                $("#cart-page #cart-list").append(cartRow);
                $("#cart-page .cart-input")
                    .last()
                    .change(function() {
                        let id = $(this).attr("data-id");
                        if ($(this).val() <= 0) {
                            removeFromCart(id, item.colorId)
                            $(this)
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .remove();
                        } else {
                            setToCart(id, $(this).val(), item.colorId)
                            let total = $(this).val() * item.price
                            $(this).parent().parent().find('.quantity').html(`$${total}`)

                        }
                        let totalPrice = cartUser.reduce((acc, cur) => acc + cur.qty * cur.price, 0)
                        let totalPay = totalPrice + 20
                        $('#cart-page #total-price').html(`$${totalPrice}`)
                        $('#cart-page #total-price').html(`$${totalPay}`)
                        $('#cart-page #btn-check-pay span').first().html(`$${totalPay}`)
                    });
                $("#cart-page .cart-item-trash")
                    .last()
                    .click(function() {
                        let id = $(this).attr("data-id");
                        removeFromCart(id, item.colorId);
                        $(this).parent().parent().parent().parent().remove();
                    });
            });
        }
    }
</script>

{{-- product detail --}}
<script>
    $(document).ready(function() {
        $('#product-detail .image-btn').each(function() {
            $(this).click(function() {
                let src = $(this).attr('src')
                $('.image-view').attr('src', src)
            })
        })
        $('#product-detail #button-except').click(function() {
            let currentVal = $('#input-qty').val()
            $('#input-qty').val(parseInt(currentVal) - 1)
            if ($('#input-qty').val() < 1) {
                $('#input-qty').val(1)
            }
        })
        $('#product-detail #button-add').click(function() {
            let currentVal = $('#input-qty').val()
            $('#input-qty').val(parseInt(currentVal) + 1)
        })
        $('#product-detail #input-qty').change(function() {
            if ($(this).val() < 1) {
                $(this).val(1)
            }
        })
        $('#product-detail #add-to-cart').click(function() {
            const id = $(this).attr('data-id')
            const name = $('#product-detail #product-name').html()
            const img = $('#product-detail .image-btn').first().attr('src')
            const price = $('#product-detail #product-price').attr('data-price')
            const colorId = $('.input-color:checked').val()
            const colorName = $('.input-color:checked').attr('data-color-name')
            const color = {
                id: colorId,
                name: colorName
            }
            const qty = $('#input-qty').val()

            if (colorId) {
                for (let i = 0; i < qty; i++) {
                    addToCart(id, name, img, price, color)
                }
            } else {
                Toastify({
                    text: "Choose color.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #dc3545, #dc8890)",
                    },
                }).showToast();
            }
        })
    })
</script>

{{-- check auth --}}
@if (auth()->check())
    <script>
        var cartUser = []
        if (Cookies.get('cart')) {
            const cart = JSON.parse(Cookies.get('cart'))
            $.ajax({
                type: "POST",
                url: "{{ route('cart.addToCart') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    cart: cart,
                    type: 'many',
                    userId: '{{ auth()->user()->id }}',
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                    cartUser = [...res.cart]
                    loadCart()
                },
                error: function(res) {
                    userCart = [...res.cart]
                    Toastify({
                        text: res.error,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                },
            });
        } else {
            $.ajax({
                type: "POST",
                url: "{{ route('cart.cartDataToView') }}",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    cartUser = [...res.cart]
                    loadCart()
                },
                error: function(e) {
                    userCart = [...res.cart]
                    loadCart()
                }
            })
        }

        const addToCart = (id, name, img, price, color) => {
            $.ajax({
                url: "{{ route('cart.addToCart') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: "one",
                    productId: id,
                    colorId: color.id,
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                    cartUser = [...res.cart]
                },
                error: function(res) {
                    userCart = [...res.cart]
                    Toastify({
                        text: res.error,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                },
            })
        }

        const exceptFromCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.exceptFromCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    type: "except",
                    productId: id,
                    colorId: colorId
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                    cartUser = [...res.cart]
                },
                error: function(res) {
                    userCart = [...res.cart]
                    Toastify({
                        text: res.error,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                },
            })
        }

        const removeFromCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.exceptFromCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    type: "remove",
                    productId: id,
                    colorId: colorId
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                    cartUser = [...res.cart]
                },
                error: function(res) {
                    userCart = [...res.cart]
                    Toastify({
                        text: res.error,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                },
            })
        }

        const setToCart = (id, qty, colorId) => {
            $.ajax({
                url: "{{ route('cart.setToCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    qty: qty,
                    colorId: colorId
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                    cartUser = [...res.cart]
                },
                error: function(res) {
                    userCart = [...res.cart]
                    Toastify({
                        text: res.error,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                },
            })
        }
    </script>
@else
    <script>
        var cartUser = !!Cookies.get("cart") ? JSON.parse(Cookies.get("cart")) : [];
        const setCookieCart = (cart) => {
            const value = JSON.stringify(cart);
            Cookies.set("cart", value, {
                expires: 7
            });
        };

        loadCart()

        //add to card
        const addToCart = (id, name, img, price, color) => {
            const existsProduct = cartUser.find((item) => item.id === id & item.colorId === color.id);
            if (existsProduct) {
                existsProduct.qty += 1;
                setCookieCart(cartUser);
            } else {
                cartUser.push({
                    id: id,
                    name: name,
                    qty: 1,
                    img: img,
                    price: price,
                    colorId: color.id,
                    colorName: color.name,
                });
                setCookieCart(cartUser);
            }
            Toastify({
                text: "Add product in cart.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        };

        //except from cart
        const exceptFromCart = (id, colorId) => {
            cartUser = cartUser.map((item, index) => {
                if (item.id === id & item.color === colorId) {
                    item.qty -= 1;
                }
                return item;
            });
            cartUser = cartUser.filter((item) => item.qty > 0 || !!item.qty);
            setCookieCart(cartUser);
            Toastify({
                text: "Deleted product from cart.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        };

        //remove from cart
        const removeFromCart = (id, colorId) => {
            cartUser = cartUser.filter((item) => item.id !== id || item.colorId !== colorId);
            setCookieCart(cartUser);
            Toastify({
                text: "Deleted product from cart.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        };

        //set to cart
        const setToCart = (id, qty, colorId) => {
            cartUser = cartUser.map((item, index) => {
                if (item.id === id & item.colorId === colorId) {
                    item.qty = qty
                }
                return item
            })
            cartUser = cartUser.filter(item => item.qty > 0)
            setCookieCart(cartUser);
            Toastify({
                text: "Changed quantity product.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        }
    </script>
@endif

{{-- handle sidebar --}}
{{-- <script>
    $(document).ready(function() {
        const productCards = $('#grid .product')

        $('#sidebar .filter').each(function() {
            $(this).change(function() {
                const categoriesChecked = []
                $('#category-list input[type="checkbox"]:checked').each(function() {
                    categoriesChecked.push($(this).val())
                })
                const colorsChecked = []
                $('#colors-list .color-item-radio:checked').each(function() {
                    colorsChecked.push($(this).attr('id'))
                })
                const sizesChecked = []
                $('#sizes-list .input-size:checked').each(function() {
                    sizesChecked.push($(this).attr('id'))
                })

                if (categoriesChecked.length == 0 & colorsChecked.length == 0 &
                    sizesChecked.length == 0) {
                    productCards.each(function() {
                        $(this).show()
                    })
                } else {
                    productCards.each(function() {
                        let check = false
                        const productCategory = $(this).find(
                                '.stats-container p')
                            .html()
                        const productColors = []
                        if ($(this).find('.input-color')) {
                            $(this).find('.input-color').each(
                                function() {
                                    productColors.push($(
                                        this).val())
                                })
                        }
                        const productSizes = []
                        if ($(this).find('.size-name')) {
                            $(this).find('.size-name').each(
                                function() {
                                    productSizes.push($(
                                        this).attr(
                                        'data-id'))
                                })
                        }
                        //check category
                        categoriesChecked.forEach(category => {
                            if (productCategory ===
                                category) {
                                $(this).show()
                                check = true
                            }
                        })
                        //check color
                        colorsChecked.forEach(item => {
                            if (productColors.find(
                                    color => color ===
                                    item)) {
                                $(this).show()
                                check = true
                            }
                        })
                        // check size
                        sizesChecked.forEach(item => {
                            if (productSizes.find(
                                    size => size ===
                                    item)) {
                                $(this).show()
                                check = true
                            }
                        })

                        if (!check) {
                            $(this).hide()
                        }
                    })
                }
            })
        })
    })
</script> --}}
