@extends('admin.layout')

@section('admin')
    <header class="p-[1.5rem] flex justify-between">
        <div class="">
            <h1 class="text-5xl">Sizes</h1>
        </div>
        <div class="text-white flex">
            <span onCLick="deleteSelectSizes()"
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
        <form id="searchFormSize" class="mt-4" action="{{ route('sizes.index') }}" method="get">
            <input type="hidden" name="pagination" value="{{ request()->pagination ? request()->pagination : 50 }}">

            <div class="fw-bold row row-cols-2 gy-5">
                {{-- name --}}
                <div class="col-md-6 flex items-center justify-end">
                    <div class="form-group mr-3">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="SearchSizeName">Size
                                name</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="A size name."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <input class="form-control text-box single-line" id="SearchSizeName" name="SearchSizeName"
                            type="text" value="{{ request('SearchSizeName') }}">
                    </div>
                </div>
                {{-- space --}}
                <div class="col-md-6">
                </div>
                {{-- minHeight --}}
                <div class="col-md-6 flex items-center justify-end">
                    <div class="form-group mr-3">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="SearchMinHeight">Min Height</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="160."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <input class="form-control text-box single-line" id="SearchMinHeight" name="SearchMinHeight"
                            type="number" value="{{ request('SearchMinHeight') }}">
                    </div>
                </div>
                {{-- maxHeight --}}
                <div class="col-md-6 flex items-center">
                    <div class="form-group mr-3">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="SearchMaxHeight">Max Height</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="160."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <input class="form-control text-box single-line" id="SearchMaxHeight" name="SearchMaxHeight"
                            type="number" value="{{ request('SearchMaxHeight') }}">
                    </div>
                </div>
                {{-- minWeight --}}
                <div class="col-md-6 flex items-center justify-end">
                    <div class="form-group mr-3">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="SearchMinWeight">Min Weight</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="50."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <input class="form-control text-box single-line" id="SearchMinWeight" name="SearchMinWeight"
                            type="number" value="{{ request('SearchMinWeight') }}">
                    </div>
                </div>
                {{-- maxWeight --}}
                <div class="col-md-6 flex items-center">
                    <div class="form-group mr-3">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="SearchMaxHeight">Max Weight</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="50."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <input class="form-control text-box single-line" id="SearchMaxHeight" name="SearchMaxHeight"
                            type="number" value="{{ request('SearchMaxHeight') }}">
                    </div>
                </div>
            </div>
            <div class="text-center pt-5">
                <button type="submit" id="search-sizes"
                    class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                    <i class="fas fa-search text-inherit mr-3"></i>
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- create --}}
    <div class="bg-white p-[20px] mb-4 rounded-lg">
        <div id="createHeader" class="flex justify-between cursor-pointer">
            <h2 class="text-4xl"><i class="fa-solid fa-circle-plus mr-3" aria-hidden="true"></i>Create</h2>
            <div class="icon-collapse">
                <i id="createIconClose" class="fa-solid fa-angle-up"></i>
                <i id="createIconOpen" class="fa-solid fa-angle-down"></i>
            </div>
        </div>
        <form id="createFormSize" class="mt-4" action="{{ route('sizes.store') }}" method="post">
            @csrf

            <div class="fw-bold row row-cols-2 gy-5">
                {{-- name --}}
                <div class="col-6 form-group flex items-center justify-end">
                    <div class="">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="name">Size
                                name</label>
                            <div title="" data-toggle="tooltip" class="ico-help"
                                data-original-title="A size name."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control max-w-[425px] text-box single-line" id="name" name="name"
                            type="text" value="{{ old('name') }}">
                        <span class="error">
                            @error('name')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </span>
                    </div>
                </div>
                {{-- space --}}
                <div class="col-6">
                </div>
                {{-- minHeight --}}
                <div class="col-6 form-group flex items-center justify-end">
                    <div class="">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="minHeight">Min Height</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="150."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control max-w-[425px] text-box single-line" id="minHeight" name="minHeight"
                            type="number" value="{{ old('minHeight') }}">
                        <span class="error">
                            @error('minHeight')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </span>
                    </div>
                </div>
                {{-- maxHeight --}}
                <div class="col-6 form-group flex items-center">
                    <div class="">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="maxHeight">Max Height</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="160."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control max-w-[425px] text-box single-line" id="maxHeight" name="maxHeight"
                            type="number" value="{{ old('maxHeight') }}">
                        <span class="error">
                            @error('maxHeight')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </span>
                    </div>
                </div>
                {{-- minWeight --}}
                <div class="col-6 form-group flex items-center justify-end">
                    <div class="">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="minWeight">Min Weight</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="50."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control max-w-[425px] text-box single-line" id="minWeight" name="minWeight"
                            type="number" value="{{ old('minWeight') }}">
                        <span class="error">
                            @error('minWeight')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </span>
                    </div>
                </div>
                {{-- maxWeight --}}
                <div class="col-6 form-group flex items-center">
                    <div class="">
                        <div class="label-wrapper flex justify-end items-center">
                            <label class="col-form-label" for="maxWeight">Max Weight</label>
                            <div title="" data-toggle="tooltip" class="ico-help" data-original-title="60."><i
                                    class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control max-w-[425px] text-box single-line" id="maxWeight" name="maxWeight"
                            type="number" value="{{ old('maxWeight') }}">
                        <span class="error">
                            @error('maxWeight')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-center m-w-[150px]">
                <button type="submit" id="create-sizes"
                    class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                    <i class="fa-solid fa-circle-plus text-inherit mr-3"></i>
                    Create
                </button>
            </div>
        </form>
    </div>

    {{-- table --}}
    <div class="p-20 bg-white rounded-lg">
        <div class='flex mb-3 justify-end'>
            <strong class="mr-3">Number sizes:</strong>
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
                <th class="text-inherit">Min height</th>
                <th class="text-inherit">Max height</th>
                <th class="text-inherit">Min weight</th>
                <th class="text-inherit">Max weight</th>
                <th class="text-inherit">Action</th>
            </tr>
            @forelse ($sizes as $size)
                <tr class="table-light" id="{{ $size->id }}">
                    <td class="p-4"><input type="checkbox" class="checkBox w-[1.6rem] h-[1.6rem]"
                            value="{{ $size->id }}" /></td>
                    <td class="p-4">
                        <span>{{ $size->name }}</span>
                        <input type="text" name="edit-name" value="{{ $size->name }}" class="form-control">
                    </td>
                    <td class="p-4">
                        <span>{{ $size->minHeight }} cm</span>
                        <input type="number" name="edit-min-height" value="{{ $size->minHeight }}"
                            class="form-control">
                    </td>
                    <td class="p-4">
                        <span>{{ $size->maxHeight }} cm</span>
                        <input type="number" name="edit-max-height" value="{{ $size->maxHeight }}"
                            class="form-control">
                    </td>
                    <td class="p-4">
                        <span>{{ $size->minWeight }} kg</span>
                        <input type="number" name="edit-min-weight" value="{{ $size->minWeight }}"
                            class="form-control">
                    </td>
                    <td class="p-4">
                        <span>{{ $size->maxWeight }} kg</span>
                        <input type="number" name="edit-max-weight" value="{{ $size->maxWeight }}"
                            class="form-control">
                    </td>
                    <td class="p-4">
                        <div class="btnBox1 flex items-center justify-center">
                            <span onClick="editSize()" class="cursor-poiter">
                                <i
                                    class="fa-solid fa-pen-to-square text-[2.4rem] text-[#3c8dbc] mr-5 hover:text-[#4e9dcb]"></i></span>
                            <span class="cursor-pointer"
                                onClick="deleteSize('{{ $size->id }}', '{{ route('sizes.destroy', ['id' => $size->id]) }}')">
                                <i class="fa-solid fa-trash-can text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                            </span>
                        </div>
                        <div class="btnBox2 flex items-center justify-center">
                            <span class="cursor-pointer"
                                onClick="updateSize('{{ $size->id }}', '{{ route('sizes.update', ['id' => $size->id]) }}')"><i
                                    class="fa-solid fa-floppy-disk text-[2.4rem] text-[#3c8dbc] mr-5 hover:text-[#4e9dcb]"></i></span>
                            <span class="cursor-pointer" onClick="closeSize()">
                                <i class="fa-solid fa-circle-xmark text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-5" colspan="11">No sizes.</td>
                </tr>
            @endforelse
        </table>
        <div class="flex justify-center mb-5">
            @include('admin.sizes.vendor.pagination')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.table-light').each(function() {
                $(this).find("input[name^='edit-']").hide()
                $(this).find(".btnBox2").hide()
            })
        })

        const editSize = () => {
            const row = $(event.target).closest('.table-light')
            row.find("input[name^='edit-']").show()
            row.find(".btnBox2").show()
            row.find("td>span").hide()
            row.find(".btnBox1").hide()
        }

        const closeSize = () => {
            const row = $(event.target).closest('.table-light')
            row.find("input[name^='edit-']").hide()
            row.find("input[name^='edit-']").each(function(){
                const oldValue = $(this).parent().find("span").html().split(' ')[0]
                $(this).val(oldValue)
            })
            row.find(".btnBox2").hide()
            row.find("td>span").show()
            row.find(".btnBox1").show()
        }

        const deleteSize = (id, url) => {
            if (confirm('Delete Size ?') === true) {
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

        const updateSize = (id, url) => {
            const row = $(event.target).closest('.table-light')
            const name = row.find("input[name='edit-name']").val()
            const minHeight = row.find("input[name='edit-min-height']").val()
            const maxHeight = row.find("input[name='edit-max-height']").val()
            const minWeight = row.find("input[name='edit-min-weight']").val()
            const maxWeight = row.find("input[name='edit-max-weight']").val()
            $.ajax({
                url: `${url}`,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    minHeight: minHeight,
                    maxHeight: maxHeight,
                    minWeight: minWeight,
                    maxWeight: maxWeight,
                },
                success: function(res) {
                    row.find("input[name^='edit-']").hide()
                    row.find("input[name^='edit-']").each(function() {
                        if ($(this).attr('name') == 'edit-name') {
                            $(this).val(res.params.name)
                            $(this).parent().find("span").html(res.params.name)
                        }
                        if ($(this).attr('name') == 'edit-min-height') {
                            $(this).val(res.params.minHeight)
                            $(this).parent().find("span").html(res.params.minHeight + " cm")
                        }
                        if ($(this).attr('name') == 'edit-max-height') {
                            $(this).val(res.params.maxHeight)
                            $(this).parent().find("span").html(res.params.maxHeight + " cm")
                        }
                        if ($(this).attr('name') == 'edit-min-weight') {
                            $(this).val(res.params.minWeight)
                            $(this).parent().find("span").html(res.params.minWeight + " kg")
                        }
                        if ($(this).attr('name') == 'edit-max-weight') {
                            $(this).val(res.params.maxWeight)
                            $(this).parent().find("span").html(res.params.maxWeight + " kg")
                        }
                    })
                    row.find(".btnBox2").hide()
                    row.find("td>span").show()
                    row.find(".btnBox1").show()
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
                        text: res.responseJSON.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                    console.log(res.validate)
                }
            })
        }

        const deleteSelectSizes = () => {
            const ids = []
            $('.checkBox:checked').each(function(i, e) {
                ids.push(e.value)
            })
            if (confirm('Delete sizes ?') === true) {
                $.ajax({
                    url: "{{ route('sizes.destroyManySizes') }}",
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
                if ($('#searchFormSize').is(':visible')) {
                    $('#searchFormSize').hide()
                    $('#searchIconOpen').hide()
                    $('#searchIconClose').show()
                } else {
                    $('#searchFormSize').show()
                    $('#searchIconOpen').show()
                    $('#searchIconClose').hide()
                }
            })
            $('#createIconClose').hide()
            $('#createHeader').on('click', function() {
                if ($('#createFormSize').is(':visible')) {
                    $('#createFormSize').hide()
                    $('#createIconOpen').hide()
                    $('#createIconClose').show()
                } else {
                    $('#createFormSize').show()
                    $('#createIconOpen').show()
                    $('#createIconClose').hide()
                }
            })
        })
    </script>
@endsection
