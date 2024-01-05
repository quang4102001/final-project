@extends('admin.layout')

@section('admin')
    <form id="product-edit" method="POST">
        @csrf

        <header class="p-[1.5rem] flex justify-between">
            <div class="flex items-end">
                <h1 class="text-5xl mr-3">Edit product details - mobile</h1><a href="{{ route('product.index') }}"
                    class="text-[#3c8dbc] hover:text-[#3c8dbc] text-[1.8rem]"><i
                        class="fa-solid fa-circle-arrow-left text-inherit mr-2"></i><span
                        class="text-inherit hover:text-[#0076bb]">back to
                        product list</span></a>
            </div>
            <div class="text-white flex">
                <button id="btn-update-form" type="submit"
                    onClick='setFormAction("{{ route('product.update', ['id' => $id]) }}")'
                    class="flex items-center px-3 py-3 rounded-lg bg-[#3c8dbc] border hover:text-white hover:bg-[#467e9f] mr-3">
                    <p class="text-inherit ">Save</p>
                </button>
                <button id="btn-delete-form" type="submit"
                    onClick='setFormAction("{{ route('product.destroy', ['id' => $id]) }}")'
                    class="flex items-center px-3 py-3 rounded-lg bg-[#dd4b39] border hover:text-white">
                    <i class="text-inherit fas fa-trash-alt mr-3"></i>
                    <p class="text-inherit ">Delete</p>
                </button>
            </div>
        </header>

        <div class="p-[1.5rem] bg-white m-3 rounded-lg shadow-md">
            <div class="mb-3 text-4xl flex items-start">
                <i class="fa-solid fa-info mr-3"></i>
                <span>Product info</span>
            </div>
            <div class="row row-cols-2 g-5">
                <div class="col">
                    <label for="form-nameProduct" class="form-label fw-bold">Name:</label>
                    <input type="text" placeholder="Example: Váy xòe dài" name="name" class="form-control"
                        id="form-nameProduct" value="{{ old('name') ?? $product->name }}" required>
                    <span class="error">
                        @error('name')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="col">
                    <label for="form-skuProduct" class="form-label fw-bold">SKU:</label>
                    <input type="text" placeholder="Example: ABC123" name="sku" class="form-control"
                        id="form-skuProduct" value="{{ old('sku') ?? $product->sku }}" required>
                    <span class="error">
                        @error('sku')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="col">
                    <label for="form-price" class="form-label fw-bold">Price ($):</label>
                    <input type="text" placeholder="Example: 100" name="price" class="form-control" id="form-price"
                        value="{{ old('price') ?? $product->price }}" required>
                    <span class="error">
                        @error('price')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="col">
                    <label for="form-discounted-price" class="form-label fw-bold">Discounted price ($):</label>
                    <input type="text" placeholder="Example: 100" name="discounted_price" class="form-control"
                        value="{{ old('discounted_price') ?? $product->discounted_price }}" id="form-discounted-price">
                    <span class="error">
                        @error('discounted_price')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="col">
                    <label for="form-category" class="form-label fw-bold">Category:</label>
                    <select class="form-select form-select-lg form-control" name="category" id="form-category"
                        value="{{ old('category') ?? $product->category }}" required>
                        @forelse ($categories as $category)
                            @if (old('category'))
                                <option value="{{ $category->name }}"
                                    {{ old('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @else
                                <option value="{{ $category->name }}"
                                    {{ $product->category == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endif
                        @empty
                            <option value="nothing">Nothing</option>
                        @endforelse
                    </select>
                    <span class="error">
                        @error('category')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
            </div>
        </div>
        {{-- màu sắc --}}
        <div class="p-[1.5rem] bg-white m-3 rounded-lg shadow-md">
            <p class="fw-bold">Colors:</p>
            <div class="flex items-center mt-3">

                @forelse ($colors as $color)
                    <div class="mx-5">
                        @if (old('colors'))
                            <input class="color-item-radio hidden" type="checkbox" name="colors[]"
                                value="{{ $color->id }}" id="{{ $color->id }}"
                                {{ in_array($color->id, old('colors')) ? 'checked' : '' }} />
                        @else
                            <input class="color-item-radio hidden" type="checkbox" name="colors[]"
                                value="{{ $color->id }}" id="{{ $color->id }}"
                                {{ in_array($color->id, $productColorIds) ? 'checked' : '' }} />
                        @endif
                        <label
                            class="color-item-label shadow-md  w-[2.4rem] h-[2.4rem] p-[2px] rounded-full border-[1px] border-transparent"
                            for="{{ $color->id }}">
                            <div class="bg-[{{ $color->name }}] rounded-full w-100 h-100 shadow-md">
                            </div>
                        </label>
                    </div>
                @empty
                    <label class="col position-absolut mb-5">
                        No have color
                    </label>
                @endforelse

            </div>
            <span class="error">
                @error('colors')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </span>
        </div>

        {{-- kích thước --}}
        <div class="p-[1.5rem] bg-white m-3 rounded-lg shadow-md">
            <p class="fw-bold">Sizes:</p>
            <div class="flex items-center mt-3">

                @forelse ($sizes as $size)
                    <label class="mx-5">
                        @if (old('sizes'))
                            <input class="" type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                {{ in_array($size->id, old('sizes')) ? 'checked' : '' }} />
                        @else
                            <input class="" type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                {{ in_array($size->id, $productSizeIds) ? 'checked' : '' }} />
                        @endif
                        <span>{{ $size->name }}</span>
                    </label>
                @empty
                    <label class="col position-absolut mb-5">
                        No have size
                    </label>
                @endforelse

            </div>
            <span class="error">
                @error('sizes')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </span>
        </div>

        {{-- hình ảnh --}}
        <div class="p-[1.5rem] m-3 bg-white rounded-lg shadow-lg">
            <p class="fw-bold mb-3">Images:</p>
            <div class="row">
                <div class="col col-3">
                    <p class="mb-3"></p>
                    <input class="block p-3 border w-100 rounded-lg" type="file" name="upload_image"
                        id="input-upload-image" accept="image/*" />
                </div>
                <div class="col col-9">
                    <p class="mb-3"></p>
                    <div id="image-list-box"
                        class="row row-cols-6 p-2 h-[300px] border border-dark position-relative overflow-auto rounded-lg">
                        @foreach ($images as $image)
                            @if (old('images'))
                                @if (in_array($image->id, old('images')))
                                    <label class="col mb-5 relative">
                                        <input class="position-absolute" type="checkbox" name="images[]"
                                            value="{{ $image->id }}" checked />
                                        <img src="{{ $image->path }}" alt="Image" style="width: 100px;">
                                    </label>
                                @endif
                            @else
                                <label class="col mb-5 relative">
                                    <input class="position-absolute" type="checkbox" name="images[]"
                                        value="{{ $image->id }}" />
                                    <img src="{{ $image->path }}" alt="Image" style="width: 100px;">
                                </label>
                            @endif
                        @endforeach
                        @foreach ($product->images as $image)
                            @if (in_array($image->id, old('images')))
                                <label class="col mb-5 relative">
                                    <input class="position-absolute" type="checkbox" name="images[]"
                                        value="{{ $image->id }}" checked />
                                    <img src="{{ $image->path }}" alt="Image" style="width: 100px;">
                                </label>
                            @endif
                        @endforeach
                        @if (!$images && !$product->images)
                        <label class="col position-absolut mb-5">
                            No have image
                        </label>
                        @endif

                    </div>
                </div>
            </div>
            <span class="error">
                @error('images')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </span>
        </div>
    </form>
    @include('admin.products.handle.ajaxImage');
    <script>
        const setFormAction = (action) => {
            document.getElementById('product-edit').action = action;
            document.getElementById('product-edit').submit();
        }
    </script>
@endsection
