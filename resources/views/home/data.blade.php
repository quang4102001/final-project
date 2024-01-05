@forelse ($products as $product)
    <div class="product col relative flex justify-center">
        <div class="info-large">
            <h4>{{ $product->name ?? 'Null' }}</h4>
            <div class="sku">
                PRODUCT SKU: <strong>{{ $product->sku ?? 'Null' }}</strong>
            </div>

            <div class="price-big">
                <span
                    class="mr-3">${{ $product->price ?? 0 }}</span>${{ $product->discounted_price ?? ($product->price ?? 0) }}
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
                @if ($product->images && count($product->images) > 0)
                    <img src="{{ $product->images[0]->path }}" alt="{{ $product->images[0]->id }}" />
                @else
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
                @endif
                <div class="image_overlay"></div>
                <div class="add_to_cart">Add to cart</div>
                <div class="view_gallery">View gallery</div>
                <div class="stats">
                    <div class="stats-container">
                        <span
                            class="product_price">${{ $product->discounted_price ?? $product->discounted_price }}</span>
                        <span class="product_id hidden">{{ $product->id }}</span>
                        <a href="{{ route('user.productDetail', ['id' => $product->id]) }}"
                            class="product_name">{{ $product->name ?? 'Null' }}</a>
                        <p>{{ $product->category ? $product->category : 'Chưa có danh mục' }}</p>

                        <div class="product-options">
                            <strong>SIZES</strong>
                            <div class="flex">
                                @forelse ($product->sizes as $size)
                                    <span class="size-name mr-3"
                                        data-id="{{ $size->id }}">{{ $size->name }}</span>
                                @empty
                                    No size.
                                @endforelse
                            </div>
                            <strong>COLORS</strong>
                            <div class="colors">
                                @forelse ($product->colors as $color)
                                    <div class="bg-[{{ $color->name }}] shadow-md"><span></span></div>
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
                                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
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
        <div class="color-box absolute top-0 left-0 w-100 h-100 bg-[#00000063] z-999 hidden">
            <div class="flex flex-column justify-center items-center h-100">
                <ul class="flex">
                    @forelse ($product->colors as $color)
                        <li>
                            <label class="w-[30px] h-[30px] rounded-full shadow-md bg-[{{ $color->name }}] p-2 mr-5">
                                <input class="w-100 h-100 input-color" type="radio" name="color"
                                    value="{{ $color->id }}" data-color="{{ $color->name }}">
                            </label>
                        </li>
                    @empty
                        <li class="px-3">
                            <label class="fw-bold bg-white p-3 rounded-lg text-red-500">Không có
                                màu, sản phẩm chưa thể mua bán.</label>
                        </li>
                    @endforelse
                </ul>
                @if ($product->colors)
                    <span class="px-4 py-2 rounded-lg bg-white mt-3 cursor-pointer btn-add-small">
                        Add
                    </span>
                @endif
                <span class="px-4 py-2 rounded-lg bg-white mt-3 cursor-pointer btn-cancel-small">
                    Cancel
                </span>
            </div>
        </div>
    </div>
@empty
    No product.
@endforelse
