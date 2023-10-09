<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="googlebot" content="noindex, nofollow"/>
    <title>@yield('title') - {{ config('env.app_name_large') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <link href="{{ secure_asset('css/admin/main.css') }}" rel="stylesheet">
    @stack('head_css')

    {{--REQUIRED JS SCRIPTS--}}
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/admin/app.js') }}"></script>

    @stack('head_js')
</head>

<body class="@yield('body_class')">
@yield('wrapper')

@stack('stack_footer_scripts')
@yield('footer_scripts')
</body>
</html>
