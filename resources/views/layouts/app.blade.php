@include('layouts.head')
@include('layouts.header')

<div class="mainBody">
    @include('layouts.sidebar')
    @yield('content')
</div>

@include('layouts.scripts')
@stack('scripts')
@include('layouts.footer')
