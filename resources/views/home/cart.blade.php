@extends('home.layout')

@section('users')
    <section id="cart-page" class="h-100 bg-white">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div id="cart-list" class="col-lg-7">
                                <h5 class="mb-3"><a href="{{ route('home') }}" class="text-body">
                                        <i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a>
                                </h5>
                                <hr>
                                @if (session('cartUser'))
                                    @foreach (session('cartUser') as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div>
                                                            <img src="{{ $item['img'] }}"
                                                                class="img-fluid rounded-3 w-[65px]" alt="Shopping item">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5>{{ $item['name'] }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div class="mr-[40px] h-100 flex items-center">
                                                            <div
                                                                class="w-[30px] h-[30px] rounded-full shadow-md bg-[{{ $item['colorName'] }}]">
                                                            </div>
                                                        </div>
                                                        <div class="mr-[40px]">
                                                            <input data-id="{{ $item['productId'] }}"
                                                                data-colorId="{{ $item['colorId'] }}"
                                                                data-price="{{ $item['price'] }}" type="number"
                                                                class="cart-input border rounded-lg leading-[2] px-3 w-[80px]"
                                                                value="{{ $item['qty'] }}" />
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0 w-[80px] quantity">
                                                                ${{ $item['price'] * $item['qty'] }}</h5>
                                                        </div>
                                                        <a data-id="{{ $item['productId'] }}"
                                                            data-colorId="{{ $item['colorId'] }}" href="#!"
                                                            class="text-[#dd4b39] cart-item-trash"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if (session('cart'))
                                    @foreach (session('cart') as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div>
                                                            <img src="{{ $item['img'] }}"
                                                                class="img-fluid rounded-3 w-[65px]" alt="Shopping item">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5>{{ $item['name'] }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div class="mr-[40px] h-100 flex items-center">
                                                            <div
                                                                class="w-[30px] h-[30px] rounded-full shadow-md bg-[{{ $item['colorName'] }}]">
                                                            </div>
                                                        </div>
                                                        <div class="mr-[40px]">
                                                            <input data-id="{{ $item['productId'] }}"
                                                                data-colorId="{{ $item['colorId'] }}"
                                                                data-price="{{ $item['price'] }}" type="number"
                                                                class="cart-input border rounded-lg leading-[2] px-3 w-[80px]"
                                                                value="{{ $item['qty'] }}" />
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0 w-[80px] quantity">
                                                                ${{ $item['price'] * $item['qty'] }}</h5>
                                                        </div>
                                                        <a data-id="{{ $item['productId'] }}"
                                                            data-colorId="{{ $item['colorId'] }}" href="#!"
                                                            class="text-[#dd4b39] cart-item-trash"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if (!session('cart') && !session('cartUser'))
                                    <p id="cart-no-item" class="py-2 flex justify-center mt-5">
                                        <i class="text-[#ccc]">No item in cart.</i>
                                    </p>
                                @endif
                            </div>
                            <div class="col-lg-5">

                                <div class="card bg-[#5ff7d2] text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">Card details</h5>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"
                                                class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">
                                        </div>

                                        <p class="small mb-2">Card type</p>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-visa fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-amex fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-paypal fa-2x"></i></a>

                                        <form class="mt-4">
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeName" class="form-control form-control-lg"
                                                    siez="17" placeholder="Cardholder's Name" />
                                                <label class="form-label" for="typeName">Cardholder's Name</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeText" class="form-control form-control-lg"
                                                    siez="17" placeholder="1234 5678 9012 3457" minlength="19"
                                                    maxlength="19" />
                                                <label class="form-label" for="typeText">Card Number</label>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="text" id="typeExp"
                                                            class="form-control form-control-lg" placeholder="MM/YYYY"
                                                            size="7" id="exp" minlength="7"
                                                            maxlength="7" />
                                                        <label class="form-label" for="typeExp">Expiration</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="password" id="typeText"
                                                            class="form-control form-control-lg"
                                                            placeholder="&#9679;&#9679;&#9679;" size="1"
                                                            minlength="3" maxlength="3" />
                                                        <label class="form-label" for="typeText">Cvv</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2">Subtotal</p>
                                            <p id="total-price" class="mb-2">$4798.00</p>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2">Shipping</p>
                                            <p class="mb-2">$20.00</p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-2">Total(Incl. taxes)</p>
                                            <p id="total-pay" class="mb-2">$4818.00</p>
                                        </div>

                                        <button type="button"
                                            class="btn btn-info btn-block btn-lg hover:bg-[#20c9979e] shadow-md border-0">
                                            <div id="btn-check-pay" class="d-flex justify-content-between">
                                                <span class="mr-3">$4818.00</span>
                                                <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('home.handleCart')
    <script>
        $(document).ready(function() {
            //change input quantity cart
            $("#cart-page .cart-input").each(function() {
                $(this).change(function() {
                    let productId = $(this).attr("data-id");
                    let colorId = $(this).attr("data-colorId");
                    let price = $(this).attr("data-price");
                    console.log(price)

                    if ($(this).val() <= 0) {
                        removeFromCart(productId, colorId)
                        $(this).closest(".card").remove();
                    } else {
                        setToCart(productId, $(this).val(), colorId)
                        let total = $(this).val() * price
                        $(this).parent().parent().find('.quantity').html(`$${total}`)

                    }
                });
            })

            //click icon trash to remove item out
            $("#cart-page .cart-item-trash").each(function() {
                $(this).click(function() {
                    let productId = $(this).attr("data-id");
                    let colorId = $(this).attr("data-colorId");
                    removeFromCart(productId, colorId);
                    $(this).closest(".card").remove();
                });
            })
        })
    </script>
@endsection
