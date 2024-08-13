@extends('layouts/commonMaster')

@section('layoutContent')
    <!-- Content -->
    @yield('content')
    {{ $slot ?? '' }}
    <!--/ Content -->
@endsection
