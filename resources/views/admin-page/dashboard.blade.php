@extends('layouts.app2')
@section('content')
        <!--BANNER-->
        @include('admin-components.dashboard.header')
        <div class="details">
            @include('admin-components.dashboard.recent-orders')
            @include('admin-components.dashboard.new-customers')
        </div>
@endsection