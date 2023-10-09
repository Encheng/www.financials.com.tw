@if(count($subNavItem->childs) > 0)
    <li class="treeview {{ ($subNavItem->active)?'nav_active active':'' }}">
        <a href="#">
            <i class="{{ $subNavItem->icon }}"></i>&nbsp;
            {{ $subNavItem->name }}
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @each('admin.layouts.includes.child_nav_items', $subNavItem->childs, 'subNavItem')
        </ul>
    </li>
@else
    <li class="{{ ($subNavItem->active)?'nav_active active':'' }}">
        <a href="{{ route($subNavItem->route_name) }} ">
            <i class="{{ $subNavItem->icon }}"></i>&nbsp;
            {{ $subNavItem->name }}
        </a>
    </li>
@endif
