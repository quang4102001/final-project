<div id="sidebar" class="border-end py-[45px] pl-[45px]">
    <div id="cart">
        <header class="d-flex justify-content-between">
            <a href="" id="cart-icon" class="d-flex align-items-center">
                <h2 class="fw-bold mr-2">Cart</h2>
                <img src="{{ asset('images/icons/cart.png') }}" alt="cart-icon" />
            </a>
            <a href="{{ route('user.cart') }}" id="checkout"
                class="border-2 border-[#5ff7d2] text-uppercase fw-bold text-[1.3rem] leading-1 px-3 py-1 text-[#5ff7d2] mr-[45px] hover:text-white hover:bg-[#5ff7d2]">
                Checkout
            </a>
        </header>
        {{-- Xử lý bằng js --}}
        <div id="cart-list" class="max-h-[300px] overflow-auto my-3">
            <p id="cart-no-item" class="py-2">
                <i class="text-[#ccc]">No item in categories.</i>
            </p>
        </div>
    </div>
    <div id="category-list" class="block mt-[45px]">
        <h2 class="category-title fw-bold tracking-[1px] text-uppercase mb-2">Category</h2>
        <ul>
            @forelse ($categories as $category)
                <li class="py-2">
                    <input type="checkbox" id="{{ $category->id }}">
                    <label class="ml-3 text-[#676a74] hover:text-[#333]"
                        for="{{ $category->id }}">{{ $category->name }}</label>
                </li>
            @empty
                <li class="py-2">
                    <i class="text-[#ccc]">No item in categories.</i>
                </li>
            @endforelse
        </ul>
    </div>
    <div id="colors-list" class="block mt-[45px]">
        <h2 class="color-title fw-bold tracking-[1px] text-uppercase mb-2">Colors</h2>
        <ul class="row row-cols-4">
            @forelse ($colors as $color)
                <li class="py-2">
                    <input class="color-item-radio hidden" type="checkbox" id="{{ $color->id }}">
                    <label class="color-item-label rounded-full p-[2px] border-[1px] border-transparent shadow-sm"
                        for="{{ $color->id }}">
                        <div class="rounded-full w-[2rem] h-[2rem] bg-[{{ $color->name }}] shadow-sm"></div>
                    </label>
                </li>
            @empty
                <li class="py-2">
                    <i class="text-[#ccc]">No item in colors.</i>
                </li>
            @endforelse
        </ul>
    </div>
    <div id="sizes-list" class="block mt-[45px]">
        <h2 class="size-title fw-bold tracking-[1px] text-uppercase mb-2">Sizes</h2>
        <ul class="row row-cols-2">
            @forelse ($sizes as $size)
                <li class="py-2">
                    <input type="checkbox" id="{{ $size->id }}">
                    <label class="ml-3 text-[#676a74] hover:text-[#333]"
                        for="{{ $size->id }}">{{ $size->name }}</label>
                </li>
            @empty
                <li class="py-2">
                    <i class="text-[#ccc]">No item in sizes.</i>
                </li>
            @endforelse
        </ul>
    </div>
    <div id="prices-list" class="block mt-[45px]">
        <h2 class="price-title fw-bold tracking-[1px] text-uppercase mb-2">Price range</h2>
        <img class="py-2" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/price-range.png" alt="price-img">
    </div>
</div>
