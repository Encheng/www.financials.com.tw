@extends('admin.layouts.cms_basic')

@section('title', '管理區')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <h3>
                <i class="fa fa-user"></i>&nbsp;{{ Auth::guard('admin')->user()->name }}，歡迎您
            </h3>
        </div>
    </div>
@stop