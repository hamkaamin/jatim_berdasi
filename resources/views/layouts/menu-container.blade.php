@if (Auth::user()->role == 1)
    @include('layouts.menu.superadmin')
@elseif(Auth::user()->role == 4 || Auth::user()->role == 5)
    @include('layouts.menu.pengusul')
@elseif(Auth::user()->role == 2)
    @include('layouts.menu.verifikator')
@else
    @include('layouts.menu.general')
@endif
