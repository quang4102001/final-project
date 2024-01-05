@extends('admin.layout')

@section('admin')
    <header class="p-[1.5rem] flex justify-between">
        <div class="">
            <h1 class="text-5xl">Images</h1>
        </div>
        <div class="text-white flex">
            <span onCLick="deleteSelectImages()"
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
        <form id="searchFormImage" class="mt-4" action="{{ route('images.index') }}" method="get">
            @csrf

            <input type="hidden" name="pagination" value="{{ request()->pagination ? request()->pagination : 50 }}">

            <div class="fw-bold">
                {{-- name --}}
                <div class="flex items-center flex-wrap gap-5">
                    <div class="form-group row gx-3 mr-3 min-w-[550px]">
                        <div class="col-md-4">
                            <div class="label-wrapper flex justify-end items-center">
                                <label class="col-form-label" for="SearchImageName">Image
                                    name</label>
                                <div title="" data-toggle="tooltip" class="ico-help"
                                    data-original-title="A image name."><i
                                        class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control max-w-[425px] text-box single-line" id="SearchImageName"
                                name="SearchImageName" type="text" value="{{ request('SearchImageName') }}">
                        </div>
                    </div>
                    <div class="text-center m-w-[150px]">
                        <button type="submit" id="search-images"
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
        <form id="createFormImage" class="mt-4" action="{{ route('images.upload') }}" method="post">
            @csrf

            <div class="fw-bold">
                <div class="flex items-center flex-wrap gap-5">
                    <div class="form-group row gx-3 mr-3 min-w-[550px]">
                        <div class="col-md-4">
                            <div class="label-wrapper flex justify-end items-center">
                                <label class="col-form-label" for="CreateImageFile">Image</label>
                                <div title="" data-toggle="tooltip" class="ico-help"
                                    data-original-title="A image name."><i
                                        class="fas fa-question-circle text-[#3c8dbc] mx-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control max-w-[425px] text-box single-line" type="file" name="image"
                                id="CreateImageFile" accept="image/*" />
                            <span class="error">
                                @error('image')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="text-center m-w-[150px]">
                        <button type="submit" id="create-image"
                            class="bg-[#3c8dbc] text-white px-5 py-3 rounded-lg text-[1.8rem] fw-normal">
                            <i class="fa-solid fa-circle-plus text-inherit mr-3"></i>
                            Create
                        </button>
                    </div>
                </div>
                <div id="imagePreview" class="mt-3">
                    <img id="preview" src="#" alt="Preview" class="w-[100px] border-x border-y shadow-md ml-[200px]">
                </div>
            </div>
        </form>
    </div>

    {{-- table --}}
    <div class="p-20 bg-white rounded-lg">
        <div class='flex mb-3 justify-end'>
            <strong class="mr-3">Number images:</strong>
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
                <th class="text-inherit">Path</th>
                <th class="text-inherit">Image</th>
                <th class="text-inherit">Action</th>
            </tr>
            @forelse ($images as $image)
                <tr class="table-light" id="{{ $image->id }}">
                    <td class="p-4"><input type="checkbox" class="checkBox w-[1.6rem] h-[1.6rem]"
                            value="{{ $image->id }}" /></td>
                    <td class="p-4">
                        <p>{{ $image->path }}</p>
                    </td>
                    <td class="p-4 flex justify-center">
                        <span><img src="{{ $image->path }}" alt="{{ $image->id }}" class="w-[50px]" /></span>
                        <input type="file" name="edit-path" value="{{ $image->path }}" class="form-control">
                    </td>
                    <td class="p-4">
                        <span class="cursor-pointer"
                            onClick="deleteImage('{{ $image->id }}', '{{ route('images.destroy', ['id' => $image->id]) }}')">
                            <i class="fa-solid fa-trash-can text-[2.4rem] text-[#dd4b39] hover:text-[#dc3545]"></i>
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-5" colspan="11">No images.</td>
                </tr>
            @endforelse
        </table>
        <div class="flex justify-center mb-5">
            @include('admin.images.vendor.pagination')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#searchIconClose').hide()
            $('#createIconClose').hide()
            $('#imagePreview').hide()

            $('#CreateImageFile').change(function(event) {
                var input = event.target;
                var preview = $('#preview');
                var imagePreview = $('#imagePreview');

                if (input.files && input.files[0]) {
                    if (input.files[0].type.startsWith('image/svg')) {
                        Toastify({
                            text: 'Not image.',
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: {
                                background: "linear-gradient(to right, #dc3545, #dc8890)",
                            }
                        }).showToast();
                    } else {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            preview.attr('src', e.target.result);
                            imagePreview.show();
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }

            });

            $('#createFormImage').submit(function() {
                event.preventDefault();
                const imageFile = $(this).find('#CreateImageFile')[0]

                if (imageFile.files[0].type.endsWith('image/svg')) {
                    Toastify({
                        text: 'Not image.',
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #dc3545, #dc8890)",
                        }
                    }).showToast();
                }

                if (imageFile.files.length > 0 && !imageFile.files[0].type.startsWith('image/svg')) {
                    let formData = new FormData();
                    formData.append('image', imageFile.files[0]);

                    $.ajax({
                        url: "{{ route('images.upload') }}",
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 700);

                            Toastify({
                                text: res.success,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                            }).showToast();

                            document.body.style.pointerEvents = 'none';
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
            })

            $('.table-light').each(function() {
                $(this).find("input[name='edit-path']").hide()
                $(this).find(".btnBox2").hide()
            })

            $('#searchHeader').on('click', function() {
                if ($('#searchFormImage').is(':visible')) {
                    $('#searchFormImage').hide()
                    $('#searchIconOpen').hide()
                    $('#searchIconClose').show()
                } else {
                    $('#searchFormImage').show()
                    $('#searchIconOpen').show()
                    $('#searchIconClose').hide()
                }
            })

            $('#createHeader').on('click', function() {
                if ($('#createFormImage').is(':visible')) {
                    $('#createFormImage').hide()
                    $('#createIconOpen').hide()
                    $('#createIconClose').show()
                } else {
                    $('#createFormImage').show()
                    $('#createIconOpen').show()
                    $('#createIconClose').hide()
                }
            })
        })

        const deleteImage = (id, url) => {
            if (confirm('Delete Image ?') === true) {
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

        const deleteSelectImages = () => {
            const ids = []
            $('.checkBox:checked').each(function(i, e) {
                ids.push(e.value)
            })
            if (confirm('Delete images ?') === true) {
                $.ajax({
                    url: "{{ route('images.destroyManyImages') }}",
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
    </script>
@endsection
