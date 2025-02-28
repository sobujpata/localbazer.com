@extends('layouts.app')
@section('content')
        <!--product to carts-->
        @include('components.order.order-list')
        @include('components.order.invoice-product')
@endsection