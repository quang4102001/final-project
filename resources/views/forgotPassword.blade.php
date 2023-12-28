@extends('index')

@section('body')
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000, // Thời gian hiển thị toast (ms)
                close: true, // Hiển thị nút đóng toast
                gravity: "top", // Vị trí hiển thị (top, bottom, left, right)
                position: "right", // Vị trí chiều ngang (left, center, right)
                style: {
                    background: "linear-gradient(to right, #dc3545, #dc8890)",
                },
            }).showToast();
        </script>
        @php
        session()->forget('error');
    @endphp
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000, // Thời gian hiển thị toast (ms)
                close: true, // Hiển thị nút đóng toast
                gravity: "top", // Vị trí hiển thị (top, bottom, left, right)
                position: "right", // Vị trí chiều ngang (left, center, right)
            }).showToast();
        </script>
        @php
        session()->forget('success');
    @endphp
    @endif

    <div class="flex min-h-[100vh] items-center bg-gradient-to-tl from-[#4e9dcb] to-[#c2c7d0]">
        <div class="container max-w-[600px] rounded-lg shadow-lg p-5 bg-white">
            <h1 class="text-5xl text-center mb-3 fw-bold">Take your password!</h1>
            <form method="POST" action="{{ route('auth.handleForgotPassword') }}">
                @csrf

                <div class="mb-3">
                    <label for="exampleInputEmail" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail" value="{{ old('email') }}">
                    <span class="error">
                        @error('email')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <button id="icon-login" type="submit"
                    class="bg-[#3c8dbc] hover:bg-[#4e9dcb] text-white shadow-md px-4 py-2 rounded mt-3">Send email</button>
                <p class="mt-3">
                    Don't have an account, click
                    <u><a href="{{ route('auth.register') }}" class="hover:text-[#3c8dbc] p-2">here</a></u>
                    to register.
                </p>
                <p class="mt-3">
                    Already have an account, click
                    <u><a href="{{ route('auth.login') }}" class="hover:text-[#3c8dbc] p-2">here</a></u>
                    to login.
                </p>
            </form>
        </div>
    </div>
@endsection