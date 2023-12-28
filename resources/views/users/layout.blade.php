@extends('index')

@section('body')
    @include('users.header.header')
    <div class="row row-cols-5 gx-0">
        <div class="col">
            @include('users.sidebar.sidebar')
        </div>
        <div class="flex-1 relative">
            @yield('users')
            <footer class="credit text-center">Author: shipra - Distributed By:
                <a title="Awesome web design code &amp; scripts" href="https://www.codehim.com?source=demo-page"
                    target="_blank">CodeHim</a>
            </footer>
        </div>

    </div>
@endsection
