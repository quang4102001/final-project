@extends('index')

@section('body')
    @include('home.header.header')
    @yield('users')

    @if (auth()->check() && !session()->exists('cartUser'))
        <script>
            $.ajax({
                url: "{{ route('cart.mergeCartWithDatabase') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    window.location.reload();
                },
                error: function(res) {
                    console.log(res)
                }
            })
        </script>
    @endif

    @if (auth()->check())
        <script>
            $.ajax({
                url: "{{ route('cart.checkDatabaseCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res)
                },
                error: function(res) {
                    console.log(res)
                }
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('cart.checkSessionCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    if (res.load) {
                        window.location.reload();
                    }
                },
                error: function(res) {
                    console.log(res)
                }
            })
        })
        const addToCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.addToCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    colorId: colorId,
                },
                success: function(res) {
                    Toastify({
                        text: res.success,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                    }).showToast();
                },
                error: function(res) {
                    Toastify({
                        text: res.error,
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
        };

        const exceptFromCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.exceptFromCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    colorId: colorId
                },
                success: function(res) {
                    if (res.success) {
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                        }).showToast();
                    }
                },
                error: function(res) {
                    Toastify({
                        text: res.error,
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
                },
                error: function(res) {
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
                url: "{{ route('cart.removeFromCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
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
                },
                error: function(res) {
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

    <script>
        $(document).ready(function() {
            //handle nut close cart item
            $(".cart-item").each(function() {
                $(this)
                    .find(".cart-item-close")
                    .click(function() {
                        let id = $(this).attr("data-id");
                        exceptFromCart(id);
                        $(this).parent().remove();
                        if ($(".cart-item").size() == 0) {
                            $("#cart-no-item").fadeIn(500);
                            $("#checkout").fadeOut(500);
                        }
                    });
            });

            $(".largeGrid").click(function() {
                $(this).find("a").addClass("active");
                $(".smallGrid a").removeClass("active");
                $("#grid").addClass("justify-between");
                $(".product")
                    .addClass("large")
                    .removeClass("justify-center")
                    .each(function() {});
                setTimeout(function() {
                    $(".info-large").show();
                }, 200);
                setTimeout(function() {
                    $(".view_gallery").trigger("click");
                }, 100);

                return false;
            });

            $(".smallGrid").click(function() {
                $(this).find("a").addClass("active");
                $(".largeGrid a").removeClass("active");
                $("#grid").removeClass("justify-between");
                $("div.product").removeClass("large");
                $("div.product").addClass("justify-center");
                $(".make3D").removeClass("animate");
                $(".info-large").fadeOut("fast");
                setTimeout(function() {
                    $("div.flip-back").trigger("click");
                }, 100);
                return false;
            });

            $(".smallGrid").click(function() {
                $(".product").removeClass("large");
                return false;
            });

            $(".colors-large a").click(function() {
                return false;
            });

            $(".product").each(function(i, el) {
                // Lift card and show stats on Mouseover
                $(el)
                    .find(".make3D")
                    .hover(
                        function() {
                            $(this).parent().css("z-index", "20");
                            $(this).addClass("animate");
                            $(this)
                                .find("div.carouselNext, div.carouselPrev")
                                .addClass("visible");
                        },
                        function() {
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
                    .click(function() {
                        $(el)
                            .find("div.carouselNext, div.carouselPrev")
                            .removeClass("visible");
                        $(el).find(".make3D").addClass("flip-10");
                        setTimeout(function() {
                            $(el)
                                .find(".make3D")
                                .removeClass("flip-10")
                                .addClass("flip90")
                                .find("div.shadow")
                                .show()
                                .fadeTo(80, 1, function() {
                                    $(el)
                                        .find(
                                            ".product-front, .product-front div.shadow"
                                        )
                                        .hide();
                                });
                        }, 50);

                        setTimeout(function() {
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
                            setTimeout(function() {
                                $(el)
                                    .find(".make3D")
                                    .removeClass("flip190")
                                    .addClass("flip180")
                                    .find("div.shadow")
                                    .hide();
                                setTimeout(function() {
                                    $(el)
                                        .find(".make3D")
                                        .css("transition", "100ms ease-out");
                                    $(el).find(".cx, .cy").addClass("s1");
                                    setTimeout(function() {
                                        $(el).find(".cx, .cy").addClass(
                                            "s2");
                                    }, 100);
                                    setTimeout(function() {
                                        $(el).find(".cx, .cy").addClass(
                                            "s3");
                                    }, 200);
                                    $(el)
                                        .find(
                                            "div.carouselNext, div.carouselPrev"
                                            )
                                        .addClass("visible");
                                }, 100);
                            }, 100);
                        }, 150);
                    });

                // Flip card back to the front side
                $(el)
                    .find(".flip-back")
                    .click(function() {
                        $(el)
                            .find(".make3D")
                            .removeClass("flip180")
                            .addClass("flip190");
                        setTimeout(function() {
                            $(el)
                                .find(".make3D")
                                .removeClass("flip190")
                                .addClass("flip90");

                            $(el)
                                .find(".product-back div.shadow")
                                .css("opacity", 0)
                                .fadeTo(100, 1, function() {
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

                        setTimeout(function() {
                            $(el)
                                .find(".make3D")
                                .removeClass("flip90")
                                .addClass("flip-10");
                            $(el)
                                .find(".product-front div.shadow")
                                .show()
                                .fadeTo(100, 0);
                            setTimeout(function() {
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
                    .each(function() {
                        carouselWidth += carouselSlideWidth;
                    });
                $(carousel).css("width", carouselWidth);

                // Load Next Image
                $(el)
                    .find("div.carouselNext")
                    .on("click", function() {
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
                        setTimeout(function() {
                            isAnimating = false;
                        }, 300);
                    });

                // Load Previous Image
                $(el)
                    .find("div.carouselPrev")
                    .on("click", function() {
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
                        setTimeout(function() {
                            isAnimating = false;
                        }, 300);
                    });
            }

            $(".sizes a span, .categories a span").each(function(i, el) {
                $(el).append('<span class="x"></span><span class="y"></span>');

                $(el)
                    .parent()
                    .on("click", function() {
                        if ($(this).hasClass("checked")) {
                            $(el).find(".y").removeClass("animate");
                            setTimeout(function() {
                                $(el).find(".x").removeClass("animate");
                            }, 50);
                            $(this).removeClass("checked");
                            return false;
                        }

                        $(el).find(".x").addClass("animate");
                        setTimeout(function() {
                            $(el).find(".y").addClass("animate");
                        }, 100);
                        $(this).addClass("checked");
                        return false;
                    });
            });
        });
    </script>
@endsection
