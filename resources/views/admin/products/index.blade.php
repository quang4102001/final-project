@extends('admin.layout')

@section('admin')
    <header class="p-[1.5rem] flex justify-between">
        <div class="">
            <h1 class="text-5xl">Products</h1>
        </div>
        <div class="text-white flex">
            <a href="{{ route('product.create') }}"
                class="flex items-center px-3 py-3 rounded-lg bg-[#3c8dbc] border hover:text-white hover:bg-[#467e9f] mr-3">
                <i class="text-inherit fas fa-plus-square mr-3"></i>
                <p class="text-inherit ">Add new</p>
            </a>
            <span onCLick="deleteSelectProducts()"
                class="flex items-center px-3 py-3 rounded-lg bg-[#dd4b39] border hover:text-white text-white cursor-pointer">
                <i class="text-inherit fas fa-trash-alt mr-3"></i>
                <p class="text-inherit ">Delete (selected)</p>
            </span>
        </div>
    </header>
    {{-- search --}}
    <div class="bg-white p-[20px] mb-4 rounded-lg">
        <div id="searchHeader" class="flex justify-between cursor-pointer">
            <h2 class="text-4xl"><i class="fas fa-search mr-3" aria-hidden="true"></i>Search</h2>
            <div class="icon-collapse">
                <i id="searchIconClose" class="fa-solid fa-angle-up"></i>
                <i id="searchIconOpen" class="fa-solid fa-angle-down"></i>
            </div>
        </div>
        <form id="searchFormProduct" class="mt-4" action="{{ route('product.index') }}" method="get">
            <input type="hidden" name="pagination" value="{{ request()->pagination ? request()->pagination : 50 }}">

            <div class="fw-bold">
                <div class="row">
                    <div class="col-md-5">
                        {{-- name --}}
                        <div class="form-group row gx-3 mb-3">
                            <div class="col-md-4">
                                <div class="label-wrapper flex justify-end items-center">
                                    <label class="col-form-label" for="SearchProductName">Product
                                        name</label>
                                    <div title="" data-toggle="tooltip" class="ico-help"
                                        data-original-title="A product name."><i
                                            class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control max-w-[425px] text-box single-line" id="SearchProductName"
                                    name="SearchProductName" type="text" value="{{ request('SearchProductName') }}">
                            </div>
                        </div>
                        {{-- category --}}
                        <div class="form-group row gx-3 mb-3">
                            <div class="col-md-4">
                                <div class="label-wrapper flex justify-end items-center">
                                    <label class="col-form-label" for="SearchCategory">Category</label>
                                    <div title="" data-toggle="tooltip" class="ico-help"
                                        data-original-title="Search by a specific category."><i
                                            class="fas fa-question-circle text-[#3c8dbc] mx-3"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control max-w-[425px]" data-val="true"
                                    data-val-required="The Category field is required." id="SearchCategory"
                                    name="SearchCategory">
                                    <option value=""
                                        {{ request('SearchCategory') == null || request('SearchCategory') == '' ? 'selected' : '' }}>
                                        All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('SearchCategory') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        {{-- status --}}
                        <div class="form-group row gx-3 mb-3">
                            <div class="col-md-4">
                                <div class="label-wrapper flex justify-end items-center">
                                    <label class="col-form-label" for="SearchStatusId">Status</label>
                                    <div title="" data-toggle="tooltip" class="ico-help"
                                        data-original-title="Search by a specific status."><i
                                            class="fas fa-question-circle text-[#3c8dbc] mx-3"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control max-w-[425px]" data-val="true"
                                    data-val-required="The Status field is required." id="SearchStatusId"
                                    name="SearchStatusId">
                                    <option value=""
                                        {{ request('SearchStatusId') == null || request('SearchStatusId') == '' ? 'selected' : '' }}>
                                        All</option>
                                    <option value="1" {{ request('SearchStatusId') == '1' ? 'selected' : '' }}>
                                        Published
                                    </option>
                                    <option value="0" {{ request('SearchStatusId') == '0' ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="form-group row gx-3 mb-3">
                            <div class="col-md-4">
                                <div class="label-wrapper flex justify-end items-center">
                                    <label class="col-form-label" for="SearchStoreId">Price</label>
                                    <div title="" data-toggle="tooltip" class="ico-help"
                                        data-original-title="Search by a specific store."><i
                                            class="fas fa-question-circle text-[#3c8dbc] mx-3"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col col-6">
                                        <label class="fw-normal" for="SearchPriceMin">From</label>
                                        <input class="form-control max-w-[425px] text-box single-line" id="SearchPriceMin"
                                            name="SearchPriceMin" type="text" value="{{ request('SearchPriceMin') }}"
                                            placeholder="10">
                                    </div>
                                    <div class="col col-6">
                                        <label class="fw-normal" for="SearchPriceMax">To</label>
                                        <input class="form-control max-w-[425px] text-box single-line" id="SearchPriceMax"
                                            name="SearchPriceMax" type="text" value="{{ request('SearchPriceMax') }}"
                                            placeholder="20">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center col-12">
                        <button type="submit" id="search-products"
                            class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                            <i class="fas fa-search text-inherit mr-3"></i>
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- table --}}
    <div class="p-20 bg-white rounded-lg">
        <div class='flex mb-3 justify-end'>
            <strong class="mr-3">Number products:</strong>
            <select id="quantitySelect" class="border-2">
                <option value="10" {{ request()->pagination == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request()->pagination == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request()->pagination == 30 ? 'selected' : '' }}>30</option>
                <option value="40" {{ request()->pagination == 40 ? 'selected' : '' }}>40</option>
                <option value="50" {{ request()->pagination == 50 ? 'selected' : '' }}
                    {{ !request()->pagination ? 'selected' : '' }}>50</option>
                <option value="60" {{ request()->pagination == 60 ? 'selected' : '' }}>60</option>
                <option value="70" {{ request()->pagination == 70 ? 'selected' : '' }}>70</option>
                <option value="80" {{ request()->pagination == 80 ? 'selected' : '' }}>80</option>
                <option value="90" {{ request()->pagination == 90 ? 'selected' : '' }}>90</option>
                <option value="100" {{ request()->pagination == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
        <table class="table table-striped table-bordered table-hover text-center">
            <tr class="fw-bold leading-[2]">
                <th class="text-inherit"><input type="checkbox" id="checkAll" class="w-[1.6rem] h-[1.6rem]" /></th>
                <th class="text-inherit">Name</th>
                <th class="text-inherit">Price</th>
                <th class="text-inherit">Discounted price</th>
                <th class="text-inherit">Category</th>
                <th class="text-inherit">Published</th>
                <th class="text-inherit">Action</th>
            </tr>
            @forelse ($products as $product)
                <tr class="table-light" id="{{ $product->id }}">
                    <td class="p-4"><input type="checkbox" class="checkBox w-[1.6rem] h-[1.6rem]"
                            value="{{ $product->id }}" /></td>
                    <td class="p-4"><a
                            href="{{ route('product.productDetail', ['id' => $product->id]) }}">{{ $product->name }}</a>
                    </td>
                    <td class="p-4">{{ $product->price }}</td>
                    <td class="p-4">{{ $product->discounted_price }}</td>
                    <td class="p-4">{{ $product->category->name }}</td>
                    <td class="p-4">
                        <label class="cursor-pointer p-1">
                            <input class="input-status hidden" type="checkbox" name="product-status-check"
                                {{ $product->status == 1 ? 'checked' : '' }}
                                onChange="setStatusAjax('{{ route('product.updateStatus', ['id' => $product->id]) }}', this)" />
                            <i
                                class="icon-status-check fa-solid fa-circle-check text-[2.4rem] text-[#3c8dbc] hover:text-[#4e9dcb]"></i>
                            <i
                                class="icon-status-xmark fa-solid fa-circle-xmark text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                        </label>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('product.edit', ['id' => $product->id]) }}"><i
                                    class="fa-solid fa-pen-to-square text-[2.4rem] text-[#3c8dbc] mr-5 hover:text-[#4e9dcb]"></i></a>
                            <span class="cursor-pointer"
                                onClick="deleteProduct('{{ $product->id }}', '{{ route('product.destroy', ['id' => $product->id]) }}')">
                                <i class="fa-solid fa-trash-can text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-5" colspan="11">No product.</td>
                </tr>
            @endforelse
        </table>
        <div class="flex justify-center mb-5">
            @include('admin.products.vendor.pagination')
        </div>
    </div>

    <script>
        const deleteProduct = (id, url) => {
            if (confirm('Delete Product ?') === true) {
                $.ajax({
                    url: `${url}`,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(res) {
                        $(`#${id}`).remove();
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                        }).showToast();
                    },
                    error: function(error) {
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
                        console.log(error)
                    }
                })
            }
        }

        const setStatusAjax = (url, e) => {
            const status = e.checked ? 1 : 0
            if (confirm('Change status ?') === true) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
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
                    error: function(err) {
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
                        console.error(err);
                    },
                });
            }
        };

        const deleteSelectProducts = () => {
            const ids = []
            $('.checkBox:checked').each(function(i, e) {
                ids.push(e.value)
            })
            if (confirm('Delete products ?') === true) {
                $.ajax({
                    url: "{{ route('product.destroyManyProducts') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids,
                    },
                    success: function(res) {
                        for (i = 0; i < ids.length; i++) {
                            $(`#${ids[i]}`).remove();
                        }
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                        }).showToast();
                    },
                    error: function(e) {
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
                        console.log(e)
                    }
                })
            }
        }

        $(document).ready(function() {
            $('#searchIconClose').hide()
            $('#searchHeader').on('click', function() {
                if ($('#searchFormProduct').is(':visible')) {
                    $('#searchFormProduct').hide()
                    $('#searchIconOpen').hide()
                    $('#searchIconClose').show()
                } else {
                    $('#searchFormProduct').show()
                    $('#searchIconOpen').show()
                    $('#searchIconClose').hide()
                }
            })
        })
    </script>
@endsection
