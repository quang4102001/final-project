@extends('admin.layout')

@section('admin')
    <header class="p-[1.5rem] flex justify-between">
        <div class="">
            <h1 class="text-5xl">Colors</h1>
        </div>
        <div class="text-white flex">
            <span onCLick="deleteSelectColors()"
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
        <form id="searchFormColor" class="mt-4" action="{{ route('colors.index') }}" method="get">
            <input type="hidden" name="pagination" value="{{ request()->pagination ? request()->pagination : 50 }}">

            <div class="fw-bold">
                {{-- name --}}
                <div class="flex items-center flex-wrap gap-5">
                    <div class="form-group row gx-3 mr-3 min-w-[550px]">
                        <div class="col-md-4">
                            <div class="label-wrapper flex justify-end items-center">
                                <label class="col-form-label" for="SearchColorName">Color
                                    code</label>
                                <div title="" data-toggle="tooltip" class="ico-help"
                                    data-original-title="A color name."><i
                                        class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control max-w-[425px] text-box single-line" id="SearchColorName"
                                name="SearchColorName" type="text" value="{{ request('SearchColorName') }}">
                        </div>
                    </div>
                    <div class="text-center m-w-[150px]">
                        <button type="submit" id="search-colors"
                            class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                            <i class="fas fa-search text-inherit mr-3"></i>
                            Search
                        </button>
                    </div>
                </div>
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
        <form id="createFormColor" class="mt-4" action="{{ route('colors.store') }}" method="post">
            @csrf

            <div class="fw-bold">
                {{-- name --}}
                <div class="flex items-center flex-wrap gap-5">
                    <div class="form-group row gx-3 mr-3 min-w-[550px]">
                        <div class="col-md-4">
                            <div class="label-wrapper flex justify-end items-center">
                                <label class="col-form-label" for="CreateColorName">Color</label>
                                <div title="" data-toggle="tooltip" class="ico-help"
                                    data-original-title="A color name."><i
                                        class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control max-w-[425px] text-box single-line" id="CreateColorName"
                                name="CreateColorName" type="color" value="{{ old('CreateColorName') }}">
                            <span class="error">
                                @error('CreateColorName')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="text-center m-w-[150px]">
                        <button type="submit" id="create-colors"
                            class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                            <i class="fa-solid fa-circle-plus text-inherit mr-3"></i>
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- table --}}
    <div class="p-20 bg-white rounded-lg">
        <div class='flex mb-3 justify-end'>
            <strong class="mr-3">Number colors:</strong>
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
                <th class="text-inherit">Color</th>
                <th class="text-inherit">Action</th>
            </tr>
            @forelse ($colors as $color)
                <tr class="table-light" id="{{ $color->id }}">
                    <td class="p-4"><input type="checkbox" class="checkBox w-[1.6rem] h-[1.6rem]"
                            value="{{ $color->id }}" /></td>
                    <td class="p-4">
                        <span class="flex items-center">
                            <div class="col-6 flex justify-end"><span
                                    class="w-[3rem] h-[3rem] rounded-full shadow-md bg-[{{ $color->name }}] mr-4"></span>
                            </div>
                            {{ $color->name }}
                        </span>
                        <input type="color" name="edit-name" value="{{ $color->name }}" class="form-control">
                    </td>
                    <td class="p-4">
                        <div class="btnBox1 flex items-center justify-center">
                            <span onClick="editColor()" class="cursor-poiter">
                                <i
                                    class="fa-solid fa-pen-to-square text-[2.4rem] text-[#3c8dbc] mr-5 hover:text-[#4e9dcb]"></i></span>
                            <span class="cursor-pointer"
                                onClick="deleteColor('{{ $color->id }}', '{{ route('colors.destroy', ['id' => $color->id]) }}')">
                                <i class="fa-solid fa-trash-can text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                            </span>
                        </div>
                        <div class="btnBox2 flex items-center justify-center">
                            <span class="cursor-pointer"
                                onClick="updateColor('{{ $color->id }}', '{{ route('colors.update', ['id' => $color->id]) }}')"><i
                                    class="fa-solid fa-floppy-disk text-[2.4rem] text-[#3c8dbc] mr-5 hover:text-[#4e9dcb]"></i></span>
                            <span class="cursor-pointer" onClick="closeColor()">
                                <i class="fa-solid fa-circle-xmark text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-5" colspan="11">No colors.</td>
                </tr>
            @endforelse
        </table>
        <div class="flex justify-center mb-5">
            @include('admin.colors.vendor.pagination')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.table-light').each(function() {
                $(this).find("input[name='edit-name']").hide()
                $(this).find(".btnBox2").hide()
            })
        })

        const editColor = () => {
            const row = $(event.target).closest('.table-light')
            const colorRegex = /#([a-fA-F0-9]{6})\b/;
            const colorMatch = row.find("td>span").html().match(colorRegex);
            row.find("input[name='edit-name']").show()
            row.find("input[name='edit-name']").val(colorMatch[0])
            row.find(".btnBox2").show()
            row.find("td>span").hide()
            row.find(".btnBox1").hide()
        }

        const closeColor = () => {
            const row = $(event.target).closest('.table-light')

            row.find("input[name='edit-name']").hide()
            row.find(".btnBox2").hide()
            row.find("td>span").show()
            row.find(".btnBox1").show()
        }

        const deleteColor = (id, url) => {
            if (confirm('Delete Color ?') === true) {
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

        const updateColor = (id, url) => {
            const row = $(event.target).closest('.table-light')
            const name = row.find("input[name='edit-name']").val()

            $.ajax({
                url: `${url}`,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                },
                success: function(res) {
                    row.find("input[name='edit-name']").hide()
                    row.find(".btnBox2").hide()
                    row.find("td>span").show()
                    row.find("td>span").html(
                        `<div class="col-6 flex justify-end"><span
                                    class="w-[3rem] h-[3rem] rounded-full shadow-md bg-[${res.name}] mr-4"></span>
                            </div>
                            ${res.name}`
                    )
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
                        text: res.error,
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

        const deleteSelectColors = () => {
            const ids = []

            $('.checkBox:checked').each(function(i, e) {
                ids.push(e.value)
            })
            if (confirm('Delete colors ?') === true) {
                $.ajax({
                    url: "{{ route('colors.destroyManyColors') }}",
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
                if ($('#searchFormColor').is(':visible')) {
                    $('#searchFormColor').hide()
                    $('#searchIconOpen').hide()
                    $('#searchIconClose').show()
                } else {
                    $('#searchFormColor').show()
                    $('#searchIconOpen').show()
                    $('#searchIconClose').hide()
                }
            })
            $('#createIconClose').hide()
            $('#createHeader').on('click', function() {
                if ($('#createFormColor').is(':visible')) {
                    $('#createFormColor').hide()
                    $('#createIconOpen').hide()
                    $('#createIconClose').show()
                } else {
                    $('#createFormColor').show()
                    $('#createIconOpen').show()
                    $('#createIconClose').hide()
                }
            })
        })
    </script>
@endsection
