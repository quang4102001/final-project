@extends('index')

@section('body')
    @include('home.header.header')
    @yield('users')

    @if (auth()->check() && !session()->exists('cartUser'))
        <script>
            $.ajax({
                url: "{{ route('cart.mergeCartWithDatabase') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    window.location.reload();
                },
                error: function(res) {
                    console.log(res)
                }
            })
        </script>
    @endif

    @if (auth()->check())
        <script>
            $.ajax({
                url: "{{ route('cart.checkDatabaseCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res)
                },
                error: function(res) {
                    console.log(res)
                }
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('cart.checkSessionCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    if (res.load) {
                        window.location.reload();
                    }
                },
                error: function(res) {
                    console.log(res)
                }
            })
        })
        const addToCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.addToCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    colorId: colorId,
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
        };

        const exceptFromCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.exceptFromCart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    colorId: colorId
                },
                success: function(res) {
                    if (res.success) {
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                        }).showToast();
                    }
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

        const setToCart = (id, qty, colorId) => {
            $.ajax({
                url: "{{ route('cart.setToCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    qty: qty,
                    colorId: colorId
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
                },
            })
        }

        const removeFromCart = (id, colorId) => {
            $.ajax({
                url: "{{ route('cart.removeFromCart') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id,
                    colorId: colorId
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
                },
            })
        }
    </script>
@endsection
