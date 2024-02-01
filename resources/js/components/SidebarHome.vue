<template>
    <div id="sidebar" class="border-end py-[45px] pl-[45px]">
        <div id="cart">
            <header class="d-flex justify-content-between">
                <span id="cart-icon" class="d-flex align-items-center">
                    <h2 class="fw-bold mr-2">Cart</h2>
                    <img src="img-cart" alt="cart-icon" />
                </span>
                <a href="#" id="checkout"
                    class="border-2 border-[#5ff7d2] text-uppercase fw-bold text-[1.3rem] leading-1 px-3 py-1 text-[#5ff7d2] mr-[45px] hover:text-white hover:bg-[#5ff7d2]">
                    Checkout
                </a>
            </header>
            <div id="cart-list" class="max-h-[300px] overflow-auto my-3">
                <!-- @if (session('cartUser'))
                @foreach (session('cartUser') as $item)
                @for ($i = 0; $i < $item['qty']; $i++) <div class="cart-item mt-4 relative">
                    <div class="d-flex items-center">
                        <div class="bg-[url('{{ $item['img'] }}')] w-[50px] h-[50px] bg-cover">
                        </div>
                        <div class="flex-1 ml-5 pr-[45px]">
                            <p class="cart-item-title">{{ $item['name'] }}</p>
                            <p class="cart-item-title text-[#5ff7d2] fw-bold">${{ $item['price'] }}</p>
                        </div>
                    </div>
                    <div class="cart-item-border mr-[45px] border-bottom mt-3"></div>
                    <i data-id="{{ $item['productId'] }}" data-colorId="{{ $item['colorId'] }}"
                        class="fa-solid fa-xmark cart-item-close hidden cursor-pointer absolute right-[18px] top-[8px] text-[2rem] text-[#ccc] p-3"></i>
            </div>
            @endfor
            @endforeach
            @endif
            @if (session('cart'))
            @foreach (session('cart') as $item)
            @for ($i = 0; $i < $item['qty']; $i++) <div class="cart-item mt-4 relative">
                <div class="d-flex items-center">
                    <div class="bg-[url('{{ $item['img'] }}')] w-[50px] h-[50px] bg-cover">
                    </div>
                    <div class="flex-1 ml-5 pr-[45px]">
                        <p class="cart-item-title">{{ $item['name'] }}</p>
                        <p class="cart-item-title text-[#5ff7d2] fw-bold">${{ $item['price'] }}</p>
                    </div>
                </div>
                <div class="cart-item-border mr-[45px] border-bottom mt-3"></div>
                <i data-id="{{ $item['productId'] }}" data-colorId="{{ $item['colorId'] }}"
                    class="fa-solid fa-xmark cart-item-close hidden cursor-pointer absolute right-[18px] top-[8px] text-[2rem] text-[#ccc] p-3"></i>
        </div>
        @endfor
        @endforeach
        @endif -->
                <p id="cart-no-item" class="py-2 hidden">
                    <i class="text-[#ccc]">No item in cart.</i>
                </p>
            </div>
        </div>
        <div id="category-list" class="block mt-[45px]">
            <h2 class="category-title fw-bold tracking-[1px] text-uppercase mb-2">Category</h2>
            <ul>
                <!-- @forelse ($categories as $category)
                @if (request()->categories)
                <li class="py-2">
                    <input type="checkbox" id="{{ $category->id }}" value="{{ $category->id }}" class="filter"
                        name="categories[]" {{ in_array($category->id, explode(',', request()->categories)) ? 'checked' : ''
                    }}>
                    <label class="ml-3 text-[#676a74] hover:text-[#333]" for="{{ $category->id }}">{{ $category -> name
                    }}</label>
                </li>
                @else
                <li class="py-2">
                    <input type="checkbox" id="{{ $category->id }}" value="{{ $category->id }}" class="filter"
                        name="categories[]">
                    <label class="ml-3 text-[#676a74] hover:text-[#333]" for="{{ $category->id }}">{{ $category -> name
                    }}</label>
                </li>
                @endif
                @empty -->
                <li class="py-2">
                    <i class="text-[#ccc]">No item in categories.</i>
                </li>
                <!-- @endforelse -->
            </ul>
        </div>
        <div id="colors-list" class="block mt-[45px]">
            <h2 class="color-title fw-bold tracking-[1px] text-uppercase mb-2">Colors</h2>
            <ul class="row row-cols-4">
                <!-- @forelse ($colors as $color)
                @if (request()->colors)
                <li class="py-2">
                    <input class="color-item-radio hidden filter" type="checkbox" id="{{ $color->id }}" {{
                        in_array($color->id,
                    explode(',', request()->colors)) ? 'checked' : '' }}>
                    <label class="color-item-label rounded-full p-[2px] border-[1px] border-transparent shadow-sm"
                        for="{{ $color->id }}">
                        <div class="rounded-full w-[2rem] h-[2rem] bg-[{{ $color->name }}] shadow-sm"></div>
                    </label>
                </li>
                @else
                <li class="py-2">
                    <input class="color-item-radio hidden filter" type="checkbox" id="{{ $color->id }}">
                    <label class="color-item-label rounded-full p-[2px] border-[1px] border-transparent shadow-sm"
                        for="{{ $color->id }}">
                        <div class="rounded-full w-[2rem] h-[2rem] bg-[{{ $color->name }}] shadow-sm"></div>
                    </label>
                </li>
                @endif
                @empty -->
                <li class="py-2">
                    <i class="text-[#ccc]">No item in colors.</i>
                </li>
                <!-- @endforelse -->
            </ul>
        </div>
        <div id="sizes-list" class="block mt-[45px]">
            <h2 class="size-title fw-bold tracking-[1px] text-uppercase mb-2">Sizes</h2>
            <ul class="row row-cols-2">
                <!-- @forelse ($sizes as $size)
                @if (request()->sizes)
                <li class="py-2">
                    <input class="input-size filter" type="checkbox" id="{{ $size->id }}" {{ in_array($size->id,
                    explode(',',
                    request()->sizes)) ? 'checked' : '' }}>
                    <label class="ml-3 text-[#676a74] hover:text-[#333]" for="{{ $size->id }}">{{ $size -> name }}</label>
                </li>
                @else
                <li class="py-2">
                    <input class="input-size filter" type="checkbox" id="{{ $size->id }}">
                    <label class="ml-3 text-[#676a74] hover:text-[#333]" for="{{ $size->id }}">{{ $size -> name }}</label>
                </li>
                @endif
                @empty -->
                <li class="py-2">
                    <i class="text-[#ccc]">No item in sizes.</i>
                </li>
                <!-- @endforelse -->
            </ul>
        </div>
        <div id="prices-list" class="block mt-[45px]">
            <h2 class="price-title fw-bold tracking-[1px] text-uppercase mb-2">Price range</h2>
        <img class="py-2" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/price-range.png" alt="price-img">
    </div>
</div></template>