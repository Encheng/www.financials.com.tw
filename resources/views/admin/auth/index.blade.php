@extends('admin.layouts.basic')

@section('title', '登入')
@section('body_class', 'login-page')

@section('wrapper')
    <div class="login-box">
        <div class="login-logo">
            <b>{{ config('env.app_name_large') }}</b>
        </div>
        <div class="login-box-body">
            @include('admin.layouts.includes.notice')
            <a href="{{ route('admin.oauth.google.redirect') }}" class="btn btn-primary btn-block btn-flat">
                使用 Google 帳號登入
            </a>
            <div class="alert alert-info alert-dismissible" style="margin-top: 30px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i>注意</h4>
                系統支援 Windows 7 (含以上) / OSX Yosemite (含以上) 作業系統之最新版 Google Chrome / Firefox / Safari 瀏覽器
            </div>
        </div>
    </div>
@endSection
