<header class="flex justify-between items-center pt-3 container">
    <a href="{{ url()->previous() }}" class="text-3xl"><i class="fa-solid fa-chevron-left text-inherit mr-3"></i>Back</a>
    @if (auth('admin')->check())
        <div class="text-white flex">
            <a href="{{ route('product.edit', ['id' => $product->id]) }}"
                class="flex items-center px-3 py-3 rounded-lg bg-[#3c8dbc] border hover:text-white hover:bg-[#467e9f] mr-3">
                <i class="text-inherit fas fa-plus-square mr-3"></i>
                <p class="text-inherit ">Edit</p>
            </a>
            <span id="btn-delete" data-url="{{ route('product.destroy', ['id' => $product->id]) }}"
                data-url-pre="{{ url()->previous() }}"
                class="flex items-center px-3 py-3 rounded-lg bg-[#dd4b39] border hover:text-white text-white cursor-pointer">
                <i class="text-inherit fas fa-trash-alt mr-3"></i>
                <p class="text-inherit ">Delete</p>
            </span>
        </div>
    @endif
</header>

<!-- content -->
<section id="product-detail" class="py-5">
    <div class="container">
        <div class="row gx-5">
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <span class="rounded-4">
                        <img style="margin: auto;" class="image-view rounded-4 fit max-h-[480px]"
                            src="{{ $product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg' }}" />
                    </span>
                </div>
                <div id="image-list" class="d-flex justify-content-center mb-3">
                    @forelse ($product->images as $image)
                        <span class="border mx-1 rounded-2 cursor-pointer">
                            <img width="60" height="60" class="image-btn rounded-2" src="{{ $image->path }}" />
                        </span>
                    @empty
                        <span class="border mx-1 rounded-2">
                            <img width="60" height="60" class="image-btn rounded-2"
                                src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" />
                        </span>
                    @endforelse
                </div>
                <!-- thumbs-wrap.// -->
                <!-- gallery-wrap .end// -->
            </aside>
            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 id="product-name" class="title text-dark text-4xl fw-bold">
                        {{ $product->name }}
                    </h4>
                    <div class="d-flex flex-row my-3">
                        <div class="text-warning mb-1 me-2">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-1">
                                4.5
                            </span>
                        </div>
                        @if ($product->status == 0)
                            <span class="text-red-500 ms-2">Discontinuing sale</span>
                        @else
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154
                                orders</span>
                            <span class="text-success ms-2">In stock</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <span id="product-price" data-price="{{ $product->price }}"
                            class="h5">${{ $product->price }}.00</span>
                        <span class="text-muted">/per box</span>
                    </div>

                    <p>
                        Modern look and quality demo item is a streetwear-inspired collection that continues to
                        break
                        away from the conventions of mainstream fashion. Made in Italy, these black and brown
                        clothing
                        low-top shirts for
                        men.
                    </p>

                    <div class="row">
                        <dt class="col-3">Category:</dt>
                        <dd class="col-9">{{ $product->category }}</dd>

                        <dt class="col-3">Material</dt>
                        <dd class="col-9">Cotton, Jeans</dd>

                        <dt class="col-3">Brand</dt>
                        <dd class="col-9">Reebook</dd>
                    </div>

                    <hr />

                    @if (auth('admin')->check() || $product->status == 0)
                        <div class="mt-4">
                            <strong class="mb-3 text-3xl">Sizes:</strong>
                            <ul class="flex items-center p-3">
                                @forelse ($product->sizes as $size)
                                    <li class="mr-3">{{ $size->name }}</li>
                                @empty
                                    <li>No size.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="mt-4">
                            <strong class="mb-3 text-3xl">Colors:</strong>
                            <ul class="flex items-center p-3">
                                @forelse ($product->colors as $color)
                                    <li class="mr-3">
                                        <div class="bg-[{{ $color->name }}] w-[30px] h-[30px] rounded-full shadow-md">
                                        </div>
                                    </li>
                                @empty
                                    <li>No color.</li>
                                @endforelse
                            </ul>
                        </div>
                    @else
                        <div class="row mb-5 mt-2">
                            <div class="col-md-4 col-4 mb-4">
                                <label class="mb-2">Size</label>
                                <select class="form-select border border-secondary text-[1.7rem] w-[100px] shadow-md">
                                    @forelse ($product->sizes as $size)
                                        <option>{{ $size->name }}</option>
                                    @empty
                                        <option>No sizes</option>
                                    @endforelse
                                </select>
                            </div>
                            <!-- col.// -->
                            <div class="col-md-8 col-8 mb-4">
                                <label class="mb-2 d-block">Color</label>
                                <div class="flex">
                                    @forelse ($product->colors as $color)
                                        <label
                                            class="w-[3rem] h-[3rem] rounded-full bg-[{{ $color->name }}] mr-3 p-2 shadow-md">
                                            <input class="input-color w-100 h-100" type="radio" name="color"
                                                value="{{ $color->id }}" data-color-name="{{ $color->name }}">
                                        </label>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <!-- col.// -->
                            <div class="col-md-6 col-8 mb-4">
                                <label class="mb-2 d-block">Quantity</label>
                                <div class="flex ">
                                    <button class="btn border-x border-y border-[#333] px-3 shadow-md" type="button"
                                        id="button-except">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number"
                                        class="text-center border-x border-y border-[#333] text-[1.7rem] w-[100px] shadow-md"
                                        id="input-qty" value="1" />
                                    <button class="btn border-x border-y border-[#333] px-3 shadow-md" type="button"
                                        id="button-add">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span id="add-to-cart" data-id="{{ $product->id }}"
                            class="cursor-pointer border-x border-y shadow-sm border-[#333] px-4 py-2 rounded bg-[#0d6efd] text-[#fff] hover:border-[#3b71ca] hover:text-[#3b71ca] hover:bg-white mr-3">
                            <i class="me-1 fa fa-shopping-basket text-inherit"></i>
                            Add to cart </span>
                        <span
                            class="cursor-pointer border-x border-y shadow-sm border-[#333] px-4 py-2 rounded bg-[#0d6efd] text-[#fff] hover:border-[#3b71ca] hover:text-[#3b71ca] hover:bg-white mr-3">
                            <i class="me-1 fa fa-heart fa-lg text-inherit"></i> Save </span>
                        <a href="{{ route('user.cart') }}"
                            class="border-x border-y shadow-sm border-[#333] px-4 py-2 rounded bg-[#0d6efd] text-[#fff] hover:border-[#3b71ca] hover:text-[#3b71ca] hover:bg-white">
                            Go to cart </a>
                    @endif
                </div>
            </main>
        </div>
    </div>
</section>
<!-- content -->

<section class="bg-light border-top py-4">
    <div class="container">
        <div class="row gx-4">
            <div class="col-lg-8 mb-4">
                <div class="border rounded-2 px-3 py-2 bg-white">
                    <!-- Pills navs -->
                    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                        <li class="nav-item d-flex" role="presentation">
                            <a class="nav-link d-flex align-items-center justify-content-center w-100 active"
                                id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
                                aria-controls="ex1-pills-1" aria-selected="true">Specification</a>
                        </li>
                        <li class="nav-item d-flex" role="presentation">
                            <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-2"
                                data-mdb-toggle="pill" href="#ex1-pills-2" role="tab"
                                aria-controls="ex1-pills-2" aria-selected="false">Warranty info</a>
                        </li>
                        <li class="nav-item d-flex" role="presentation">
                            <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-3"
                                data-mdb-toggle="pill" href="#ex1-pills-3" role="tab"
                                aria-controls="ex1-pills-3" aria-selected="false">Shipping info</a>
                        </li>
                        <li class="nav-item d-flex" role="presentation">
                            <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-4"
                                data-mdb-toggle="pill" href="#ex1-pills-4" role="tab"
                                aria-controls="ex1-pills-4" aria-selected="false">Seller profile</a>
                        </li>
                    </ul>
                    <!-- Pills navs -->

                    <!-- Pills content -->
                    <div class="tab-content" id="ex1-content">
                        <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel"
                            aria-labelledby="ex1-tab-1">
                            <p>
                                With supporting text below as a natural lead-in to additional content. Lorem ipsum
                                dolor
                                sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                                et
                                dolore magna aliqua. Ut
                                enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                ea
                                commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum
                                dolore eu fugiat nulla
                                pariatur.
                            </p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-check text-success me-2"></i>Some great feature name
                                            here
                                        </li>
                                        <li><i class="fas fa-check text-success me-2"></i>Lorem ipsum dolor sit
                                            amet,
                                            consectetur</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Duis aute irure dolor in
                                            reprehenderit</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Optical heart sensor</li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 mb-0">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Easy fast and ver good
                                        </li>
                                        <li><i class="fas fa-check text-success me-2"></i>Some great feature name
                                            here
                                        </li>
                                        <li><i class="fas fa-check text-success me-2"></i>Modern style and design
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <table class="table border mt-3 mb-2">
                                <tr>
                                    <th class="py-2">Display:</th>
                                    <td class="py-2">13.3-inch LED-backlit display with IPS</td>
                                </tr>
                                <tr>
                                    <th class="py-2">Processor capacity:</th>
                                    <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                                </tr>
                                <tr>
                                    <th class="py-2">Camera quality:</th>
                                    <td class="py-2">720p FaceTime HD camera</td>
                                </tr>
                                <tr>
                                    <th class="py-2">Memory</th>
                                    <td class="py-2">8 GB RAM or 16 GB RAM</td>
                                </tr>
                                <tr>
                                    <th class="py-2">Graphics</th>
                                    <td class="py-2">Intel Iris Plus Graphics 640</td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade mb-2" id="ex1-pills-2" role="tabpanel"
                            aria-labelledby="ex1-tab-2">
                            Tab content or sample information now <br />
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco
                            laboris nisi ut
                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                            velit
                            esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident,
                            sunt in culpa qui
                            officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur
                            adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim
                            ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        </div>
                        <div class="tab-pane fade mb-2" id="ex1-pills-3" role="tabpanel"
                            aria-labelledby="ex1-tab-3">
                            Another tab content or sample information now <br />
                            Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                            et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi
                            ut aliquip ex ea
                            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                            dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                            culpa qui officia deserunt
                            mollit anim id est laborum.
                        </div>
                        <div class="tab-pane fade mb-2" id="ex1-pills-4" role="tabpanel"
                            aria-labelledby="ex1-tab-4">
                            Some other tab content or sample information now <br />
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco
                            laboris nisi ut
                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                            velit
                            esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident,
                            sunt in culpa qui
                            officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                    <!-- Pills content -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="px-0 border rounded-2 shadow-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Similar items</h5>
                            @forelse ($products as $product)
                                <div class="d-flex mb-3 hover:bg-[#eee]">
                                    <a href="{{ auth('admin')->check() ? route('product.productDetail', ['id' => $product->id]) : route('user.productDetail', ['id' => $product->id]) }}"
                                        class="me-3">
                                        <img src="{{ $product->images[0]->path ?? 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg' }}"
                                            class="img-md img-thumbnail h-[96px]" />
                                    </a>
                                    <div class="info">
                                        <a href="{{ auth('admin')->check() ? route('product.productDetail', ['id' => $product->id]) : route('user.productDetail', ['id' => $product->id]) }}"
                                            class="nav-link mb-1 text-[#333] fw-bold">
                                            {{ $product->name }} <br />
                                        </a>
                                        <strong class="text-dark nav-link"> ${{ $product->price }}.00</strong>
                                    </div>
                                </div>
                            @empty
                                <p>No product.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('users.handleCart')

<script>
    $(document).ready(function() {
        $('#btn-delete').click(function() {
            const url = $(this).attr('data-url')
            const urlPre = $(this).attr('data-url-pre')
            if (confirm('Delete product') === true) {
                $.ajax({
                    url: `${url}`,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(res) {
                        window.location.href = urlPre
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
                            },
                        }).showToast();
                    }

                })
            }
        })
    })
</script>
