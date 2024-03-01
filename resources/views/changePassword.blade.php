@extends('index')

@section('body')
    <a href="{{ route('home') }}"
        class="bg-gradient-to-r from-sky-500 to-indigo-500 fixed top-5 left-5 p-4 rounded-lg shadow-md text-white transform hover:translate-x-1 hover:translate-y-[1px] hover:scale-[1.01]  hover:shadow-lg fw-bold">
        <i class="fa-solid fa-arrow-left text-inherit mr-3"></i> Back
    </a>

    <div class="flex min-h-[100vh] items-center bg-gradient-to-tl from-[#4e9dcb] to-[#c2c7d0]">
        <div class="container max-w-[600px] rounded-lg shadow-lg p-5 bg-white">
            <h1 class="text-5xl text-center mb-3 fw-bold">Change your password!</h1>
            <form method="POST" action="{{ route('auth.handleChangePassword') }}">
                @csrf

                <div class="mb-3">
                    <label for="exampleInputOldPassword" class="form-label">Old Password</label>
                    <input name="old_password" type="password" class="form-control" id="exampleInputOldPassword"
                        value="{{ old('old_password') }}">
                    <span class="error">
                        @error('old_password')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword"
                        value="{{ old('password') }}">
                    <span class="error">
                        @error('password')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputRePassword" class="form-label">Confirm Password</label>
                    <input name="re_password" type="password" class="form-control" id="exampleInputRePassword"
                        value="{{ old('re_password') }}">
                    <span class="error">
                        @error('re_password')
                            <span class="text-red-400">{{ $message }}</span>
                        @enderror
                    </span>
                </div>
                <button id="icon-login" type="submit"
                    class="bg-[#3c8dbc] hover:bg-[#4e9dcb] text-white shadow-md px-4 py-2 rounded mt-3">Change
                    Password</button>
            </form>
        </div>
    </div>
@endsection
