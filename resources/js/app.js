import "./bootstrap";
var cartUser = !!Cookies.get("cart") ? JSON.parse(Cookies.get("cart")) : [];
const setCookieCart = (cart) => {
    const value = JSON.stringify(cart);
    Cookies.set("cart", value, { expires: 7 });
};

//make cartItem
const makeCartItem = (name, img, price, id) => {
    return `<div class="cart-item mt-4 relative">
                <div class="d-flex">
                    <div class="bg-[url('${img}')] w-[50px] h-[50px] bg-cover">
                    </div>
                    <div class="flex-1 ml-5 pr-[45px]">
                        <p class="cart-item-title">${name}</p>
                        <p class="cart-item-title text-[#5ff7d2] fw-bold">${price}</p>
                    </div>
                </div>
                <div class="cart-item-border mr-[45px] border-bottom mt-3"></div>
                <i data-id="${id}" class="fa-solid fa-xmark cart-item-close hidden cursor-pointer absolute right-[18px] top-[20px] text-[2rem] text-[#ccc]"></i>
            </div>`;
};

//load card
if (cartUser.length === 0) {
    $("#cart-no-item").show();
    $("#checkout").hide();
} else {
    $("#cart-no-item").hide();
    $("#checkout").show();
    cartUser.forEach((item, index) => {
        const cartItem = makeCartItem(item.name, item.img, item.price, item.id);
        for (let i = 0; i < item.qty; i++) {
            $("#cart-list").append(cartItem);
        }
    });
}
//

//add to card
const addToCart = (id, name, img, price) => {
    const existsProduct = cartUser.find((item) => item.id === id);
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
        });
        setCookieCart(cartUser);
    }
    Toastify({
        text: "Thêm thành công",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
    }).showToast();
};

//remove from cart
const removeFromCart = (id) => {
    cartUser = cartUser.map((item, index) => {
        if (item.id === id) {
            item.qty -= 1;
        }
        return item;
    });
    cartUser = cartUser.filter((item) => item.qty > 0 || !!item.qty);
    setCookieCart(cartUser);
    Toastify({
        text: "Xóa thành công",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
    }).showToast();
};

// users/index
$(document).ready(function () {
    //handle nut close cart item
    $(".cart-item").each(function () {
        $(this)
            .find(".cart-item-close")
            .click(function () {
                let id = $(this).attr("data-id");
                removeFromCart(id);
                $(this).parent().remove();
                if ($(".cart-item").size() == 0) {
                    $("#cart-no-item").fadeIn(500);
                    $("#checkout").fadeOut(500);
                }
            });
    });

    const addCartInterface = (productCard, type) => {
        const position = productCard.offset();
        //lấy data
        const productImage = $(productCard).find("img").get(0).src;
        const productId = $(productCard).find(".product_id").get(0).innerHTML;
        const productName = $(productCard)
            .find(".product_name")
            .get(0).innerHTML;
        const productPrice = $(productCard)
            .find(".product_price")
            .get(0).innerHTML;

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
            .css({ top: position.top + "px", left: position.left + "px" })
            .fadeIn("slow")
            .addClass("moveToCart");
        setTimeout(function () {
            $("body").addClass("MakeFloatingCart");
        }, 800);

        setTimeout(function () {
            $("div.floating-cart").remove();
            $("body").removeClass("MakeFloatingCart");
            $("#cart-no-item").hide();
            const cartItem = makeCartItem(
                productName,
                productImage,
                productPrice,
                productId
            );
            $("#cart-list").prepend(cartItem);
            $("#checkout").fadeIn(500);

            $("#cart-list .cart-item")
                .first()
                .find(".cart-item-close")
                .click(function () {
                    $(this)
                        .parent()
                        .fadeOut(300, function () {
                            removeFromCart(productId);
                            $(this).remove();
                            if ($("#cart-list .cart-item").size() == 0) {
                                $("#cart-no-item").fadeIn(500);
                                $("#checkout").fadeOut(500);
                            }
                        });
                });
        }, 800);
        // Thêm vào giỏ hàng
        addToCart(productId, productName, productImage, productPrice);
        //
    };

    $(".largeGrid").click(function () {
        $(this).find("a").addClass("active");
        $(".smallGrid a").removeClass("active");
        $("#grid").addClass("justify-between");
        $(".product")
            .addClass("large")
            .removeClass("justify-center")
            .each(function () {});
        setTimeout(function () {
            $(".info-large").show();
        }, 200);
        setTimeout(function () {
            $(".view_gallery").trigger("click");
        }, 100);

        return false;
    });

    $(".smallGrid").click(function () {
        $(this).find("a").addClass("active");
        $(".largeGrid a").removeClass("active");
        $("#grid").removeClass("justify-between");
        $("div.product").removeClass("large");
        $("div.product").addClass("justify-center");
        $(".make3D").removeClass("animate");
        $(".info-large").fadeOut("fast");
        setTimeout(function () {
            $("div.flip-back").trigger("click");
        }, 100);
        return false;
    });

    $(".smallGrid").click(function () {
        $(".product").removeClass("large");
        return false;
    });

    $(".colors-large a").click(function () {
        return false;
    });

    $(".product").each(function (i, el) {
        // Lift card and show stats on Mouseover
        $(el)
            .find(".make3D")
            .hover(
                function () {
                    $(this).parent().css("z-index", "20");
                    $(this).addClass("animate");
                    $(this)
                        .find("div.carouselNext, div.carouselPrev")
                        .addClass("visible");
                },
                function () {
                    $(this).removeClass("animate");
                    $(this).parent().css("z-index", "1");
                    $(this)
                        .find("div.carouselNext, div.carouselPrev")
                        .removeClass("visible");
                }
            );

        // Flip card to the back side
        $(el)
            .find(".view_gallery")
            .click(function () {
                $(el)
                    .find("div.carouselNext, div.carouselPrev")
                    .removeClass("visible");
                $(el).find(".make3D").addClass("flip-10");
                setTimeout(function () {
                    $(el)
                        .find(".make3D")
                        .removeClass("flip-10")
                        .addClass("flip90")
                        .find("div.shadow")
                        .show()
                        .fadeTo(80, 1, function () {
                            $(el)
                                .find(
                                    ".product-front, .product-front div.shadow"
                                )
                                .hide();
                        });
                }, 50);

                setTimeout(function () {
                    $(el)
                        .find(".make3D")
                        .removeClass("flip90")
                        .addClass("flip190");
                    $(el)
                        .find(".product-back")
                        .show()
                        .find("div.shadow")
                        .show()
                        .fadeTo(90, 0);
                    setTimeout(function () {
                        $(el)
                            .find(".make3D")
                            .removeClass("flip190")
                            .addClass("flip180")
                            .find("div.shadow")
                            .hide();
                        setTimeout(function () {
                            $(el)
                                .find(".make3D")
                                .css("transition", "100ms ease-out");
                            $(el).find(".cx, .cy").addClass("s1");
                            setTimeout(function () {
                                $(el).find(".cx, .cy").addClass("s2");
                            }, 100);
                            setTimeout(function () {
                                $(el).find(".cx, .cy").addClass("s3");
                            }, 200);
                            $(el)
                                .find("div.carouselNext, div.carouselPrev")
                                .addClass("visible");
                        }, 100);
                    }, 100);
                }, 150);
            });

        // Flip card back to the front side
        $(el)
            .find(".flip-back")
            .click(function () {
                $(el)
                    .find(".make3D")
                    .removeClass("flip180")
                    .addClass("flip190");
                setTimeout(function () {
                    $(el)
                        .find(".make3D")
                        .removeClass("flip190")
                        .addClass("flip90");

                    $(el)
                        .find(".product-back div.shadow")
                        .css("opacity", 0)
                        .fadeTo(100, 1, function () {
                            $(el)
                                .find(".product-back, .product-back div.shadow")
                                .hide();
                            $(el)
                                .find(
                                    ".product-front, .product-front div.shadow"
                                )
                                .show();
                        });
                }, 50);

                setTimeout(function () {
                    $(el)
                        .find(".make3D")
                        .removeClass("flip90")
                        .addClass("flip-10");
                    $(el)
                        .find(".product-front div.shadow")
                        .show()
                        .fadeTo(100, 0);
                    setTimeout(function () {
                        $(el).find(".product-front div.shadow").hide();
                        $(el)
                            .find(".make3D")
                            .removeClass("flip-10")
                            .css("transition", "100ms ease-out");
                        $(el).find(".cx, .cy").removeClass("s1 s2 s3");
                    }, 100);
                }, 150);
            });

        makeCarousel(el);
    });

    $(".add-cart-large").each(function (i, el) {
        $(el).click(function () {
            const productCard = $(this).parent().parent();
            addCartInterface(productCard, 1);
        });
    });

    /* ----  Image Gallery Carousel   ---- */
    function makeCarousel(el) {
        var carousel = $(el).find(".carousel ul");
        var carouselSlideWidth = 315;
        var carouselWidth = 0;
        var isAnimating = false;
        var currSlide = 0;
        $(carousel).attr("rel", currSlide);

        // building the width of the casousel
        $(carousel)
            .find("li")
            .each(function () {
                carouselWidth += carouselSlideWidth;
            });
        $(carousel).css("width", carouselWidth);

        // Load Next Image
        $(el)
            .find("div.carouselNext")
            .on("click", function () {
                var currentLeft = Math.abs(parseInt($(carousel).css("left")));
                var newLeft = currentLeft + carouselSlideWidth;
                if (newLeft == carouselWidth || isAnimating === true) {
                    return;
                }
                $(carousel).css({
                    left: "-" + newLeft + "px",
                    transition: "300ms ease-out",
                });
                isAnimating = true;
                currSlide++;
                $(carousel).attr("rel", currSlide);
                setTimeout(function () {
                    isAnimating = false;
                }, 300);
            });

        // Load Previous Image
        $(el)
            .find("div.carouselPrev")
            .on("click", function () {
                var currentLeft = Math.abs(parseInt($(carousel).css("left")));
                var newLeft = currentLeft - carouselSlideWidth;
                if (newLeft < 0 || isAnimating === true) {
                    return;
                }
                $(carousel).css({
                    left: "-" + newLeft + "px",
                    transition: "300ms ease-out",
                });
                isAnimating = true;
                currSlide--;
                $(carousel).attr("rel", currSlide);
                setTimeout(function () {
                    isAnimating = false;
                }, 300);
            });
    }

    $(".sizes a span, .categories a span").each(function (i, el) {
        $(el).append('<span class="x"></span><span class="y"></span>');

        $(el)
            .parent()
            .on("click", function () {
                if ($(this).hasClass("checked")) {
                    $(el).find(".y").removeClass("animate");
                    setTimeout(function () {
                        $(el).find(".x").removeClass("animate");
                    }, 50);
                    $(this).removeClass("checked");
                    return false;
                }

                $(el).find(".x").addClass("animate");
                setTimeout(function () {
                    $(el).find(".y").addClass("animate");
                }, 100);
                $(this).addClass("checked");
                return false;
            });
    });

    $(".add_to_cart").click(function () {
        const productCard = $(this).parent();
        addCartInterface(productCard, 2);
    });
});
