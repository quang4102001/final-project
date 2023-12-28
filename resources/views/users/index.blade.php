@extends('users.layout')

@section('users')
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        </script>
        @php
            session()->forget('success');
        @endphp
    @endif
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

    <div id="grid" class="relative w-100 row row-cols-4 g-5 left-[7.5px] p-5">
        @forelse ($products as $product)
            <div class="product col relative flex justify-center">
                <div class="info-large">
                    <h4>{{ $product->name }}</h4>
                    <div class="sku">
                        PRODUCT SKU: <strong>{{ $product->sku }}</strong>
                    </div>

                    <div class="price-big">
                        <span class="mr-3">${{ $product->price }}</span>${{ $product->discounted_price }}
                    </div>

                    <h3>COLORS</h3>
                    <div class="colors-large">
                        <ul>
                            @forelse ($product->colors as $color)
                                <li><a href="" class="bg-[{{ $color->name }}]"><span></span></a></li>
                            @empty
                                No color.
                            @endforelse
                        </ul>
                    </div>

                    <h3>SIZE</h3>
                    <div class="sizes-large">
                        @forelse ($product->sizes as $size)
                            <span>{{ $size->name }}</span>
                        @empty
                            No size.
                        @endforelse
                    </div>

                    <button class="add-cart-large">Add To Cart</button>

                </div>
                <div class="make3D">
                    <div class="product-front">
                        <div class="shadow"></div>
                        @if (count($product->images) > 0)
                            <img src="{{ $product->images[0]->path }}" alt="{{ $product->images[0]->id }}" />
                        @else
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
                        @endif
                        <div class="image_overlay"></div>
                        <div class="add_to_cart">Add to cart</div>
                        <div class="view_gallery">View gallery</div>
                        <div class="stats">
                            <div class="stats-container">
                                <span class="product_price">${{ $product->discounted_price }}</span>
                                <span class="product_id hidden">${{ $product->id }}</span>
                                <span class="product_name">FLUTED HEM DRESS</span>
                                <p>Summer dress</p>

                                <div class="product-options">
                                    <strong>SIZES</strong>
                                    <span>
                                        @forelse ($product->sizes as $size)
                                            {{ $size->name }}
                                        @empty
                                            No size.
                                        @endforelse
                                    </span>
                                    <strong>COLORS</strong>
                                    <div class="colors">
                                        @forelse ($product->colors as $color)
                                            <div class="bg-[{{ $color->name }}]"><span></span></div>
                                        @empty
                                            No color.
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-back">
                        <div class="shadow"></div>
                        <div class="carousel">
                            <ul class="carousel-container">
                                @forelse ($product->images as $image)
                                    <li><img src="{{ $image->path }}" alt="{{ $image->id }}" />
                                    </li>
                                @empty
                                    <li>
                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg"
                                            alt="" />
                                    </li>
                                @endforelse
                            </ul>
                            <div class="arrows-perspective">
                                <div class="carouselPrev">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                                <div class="carouselNext">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flip-back">
                            <div class="cy"></div>
                            <div class="cx"></div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            No product.
        @endforelse
    </div>
    <div class="flex justify-center mb-5">
        @include('vendor.pagination')
    </div>
@endsection
