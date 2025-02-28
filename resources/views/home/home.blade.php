@extends('layouts.app')
@section('content')
        @include('components.home.model')
        
        {{-- @include('components.home.notification-toast') --}}
        <!--BANNER-->
        @include('components.home.banner')

        <!--- CATEGORY-->
        @include('components.home.category')
       
        <!--- PRODUCT-->
        @include('components.home.product')

        <!--- TESTIMONIALS, CTA & SERVICE-->
        @include('components.home.testimonial')

        <!--- BLOG-->
        {{-- @include('components.home.blog') --}}
@endsection
