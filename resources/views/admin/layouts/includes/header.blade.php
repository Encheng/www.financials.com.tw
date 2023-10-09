<header class="main-header">
    {{-- Logo --}}
    <a href="{{ route('admin.index') }}" class="logo">
        {{-- mini logo for sidebar mini 50x50 pixels --}}
        <span class="logo-mini">
            <b>{{ config('env.app_name_mini') }}</b>
        </span>
        {{-- logo for regular state and mobile devices --}}
        <span class="logo-lg">
            <b>{{config('env.app_name_large')}}</b>
        </span>
    </a>

    {{-- Header Navbar --}}
    {{-- fixme display:block; 臨時解決方案--}}
    <nav class="navbar navbar-static-top" role="navigation" style="padding: inherit; display: block;">
        {{-- Sidebar toggle button --}}
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        {{-- Navbar Right Menu --}}
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{-- User Account Menu --}}
                <li class="dropdown user user-menu">
                    {{-- Menu Toggle Button --}}
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">{{ Auth::guard('admin')->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        {{-- The user image in the menu --}}
                        <li class="user-header">
                            <p>{{ Auth::guard('admin')->user()->email }}</p>
                        </li>
                        {{-- Menu Footer --}}
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">
                                    登出
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
