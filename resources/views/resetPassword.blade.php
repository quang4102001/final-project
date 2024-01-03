@extends('index')

@section('body')

    <div class="flex min-h-[100vh] items-center bg-gradient-to-tl from-[#4e9dcb] to-[#c2c7d0]">
        <div class="container max-w-[600px] rounded-lg shadow-lg p-5 bg-white">
            <h1 class="text-5xl text-center mb-3 fw-bold">Reset your password!</h1>
            <form method="POST" action="{{ route('auth.handleResetPassword', $token) }}">
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
                <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword" value="{{ old('password') }}">
                    <span class="error">
                        @error('password')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputRePassword" class="form-label">Password</label>
                    <input name="rePassword" type="password" class="form-control" id="exampleInputRePassword" value="{{ old('rePassword') }}">
                    <span class="error">
                        @error('rePassword')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <button id="icon-login" type="submit"
                    class="bg-[#3c8dbc] hover:bg-[#4e9dcb] text-white shadow-md px-4 py-2 rounded mt-3">ResetPassword</button>
            </form>
        </div>
    </div>
@endsection
