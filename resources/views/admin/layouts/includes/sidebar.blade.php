<aside class="main-sidebar">
    {{-- sidebar: style can be found in sidebar.less --}}
    <section class="sidebar">
        {{-- Sidebar Menu --}}
        <ul class="sidebar-menu" data-widget="tree">
            @foreach($sideBarNavItems as $navItem)
                @if(count($navItem->childs) <= 0)
                    @continue
                @endif
                <li class="treeview {{ ($navItem->active)?'nav_active active':'' }}">
                    <a href="#">
                        <i class="{{ $navItem->icon }}"></i>
                        <span>{{ $navItem->name }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @each('admin.layouts.includes.child_nav_items', $navItem->childs,'subNavItem')
                    </ul>
                </li>
            @endforeach
        </ul>
    </section>
</aside>

<script type="text/javascript">
$(document).ready(function () {
  $('li.nav_active').parentsUntil($('ul.sidebar-menu')).addClass('active menu-open');
  $('form').submit(function () {
    $('button[type=submit]').attr('disabled', true);
  });
});
</script>
