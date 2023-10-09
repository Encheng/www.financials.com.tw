@extends('admin.layouts.basic')

@section('body_class','hold-transition skin-blue sidebar-mini')

@section('wrapper')
    <div class="wrapper">
        {{-- Header--}}
        @include('admin.layouts.includes.header')
        {{-- Left side column. contains the logo and sidebar--}}
        @include('admin.layouts.includes.sidebar')

        {{-- Content Wrapper. Contains page content--}}
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    @section('content_header')
                        <small></small>
                    @show
                </h1>
                @include('admin.layouts.includes.breadcrumb')
            </section>

            {{-- Main content--}}
            <section class="content">
                @include('admin.layouts.includes.notice')

                {{-- Your Page Content Here--}}
                @yield('content')
            </section>
        </div>

        {{-- Main Footer --}}
        @include('admin.layouts.includes.footer')
    </div>
@stop
